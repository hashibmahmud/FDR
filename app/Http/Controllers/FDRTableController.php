<?php

namespace App\Http\Controllers;

use App\Mail\FDRCreated;
use App\Mail\Remind;
use App\Mail\Renewed;
use Auth;
use App\Models\FDRTable;
use App\Models\Instrument;
use App\Models\Notification;
use App\Models\Renew;
use App\Models\Signatory;
use App\Models\User;
use App\Notifications\SendMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class FDRTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (Auth::check()) {
            $fdr = FDRTable::find($id);
            if ($fdr == null) return "No FDR found";
            $signatories = Signatory::where('fdr_id', '=', $id)->get();
            $instruments = Instrument::where('fdr_id', '=', $id)->get();
            $notifications = Notification::where('fdr_id', '=', $id)->get();
            return view('single_fdr', [
                'fdr' => $fdr,
                'sigs' => $signatories,
                'instruments' => $instruments,
                'notifications' => $notifications
            ]);
        }
        return "Unauthorized";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Auth::check()) {
            return "Unauthorized";
        }
        $data = $request->input();
        $files = $request->file();
        $fdr = new FDRTable;

        $fdr->fdr_number = $data['fdr_no'];
        $fdr->bank_name = $data['bank_name'];
        $fdr->branch_name = $data['branch_name'];
        $fdr->opening_amount = $data['opening_amount'];
        $fdr->opening_date = $data['open_date'];
        $fdr->period = $data['period'];
        $fdr->next_maturity = Carbon::createFromDate($data['closing_date']);
        $fdr->interest = $data['interest'];
        $fdr->contact_person = $data['contact_person'];
        $fdr->contact_number = $data['contact_number'];
        $fdr->status = "pending";
        $fdr->creator = Auth::user()->email;
        $fdr->save();
        DB::commit();

        $fdr_id = $fdr->id;
        foreach ($data as $key => $value) {
            if (substr($key, 0, 3) === "sig") {
                $signatory = new Signatory;
                $signatory->fdr_id = $fdr_id;
                $signatory->signatory = $value;
                $signatory->save();
                DB::commit();
            } else if (substr($key, 0, 4) === "date") {
                $ch = substr($key, -1);
                $notif = new Notification;
                $notif->fdr_id = $fdr_id;
                $notif->date = $value;
                $notif->time = $data['time' . $ch];
                $notif->recipient = $data['recipient' . $ch];
                $notif->save();
                DB::commit();

                //send mail after fdr creation
                Mail::to(Auth::user()->email)->queue(new FDRCreated($fdr->fdr_number, $fdr->bank_name, $fdr->branch_name));
                $recipients = explode(',', $notif->recipient);
                foreach ($recipients as $person) {
                    Mail::to($person)->later(Carbon::parse($value . " " . $data['time' . $ch]), new Remind($fdr->fdr_number, $fdr->bank_name, $fdr->branch_name, $fdr->next_maturity));
                }
            }
        }

        foreach ($files as $key => $value) {
            $file = $request->file($key);
            $oldFileName = $file->getClientOriginalName();

            $instrument = new Instrument;
            $instrument->fdr_id = $fdr_id;
            $instrument->old_file_name = $oldFileName;
            $newFileName = $fdr->fdr_number . "_" . $this->maxId() . "." . $file->getClientOriginalExtension();
            $instrument->new_file_name = $newFileName;
            $instrument->save();
            $file->move('uploads/', $newFileName);
            DB::commit();
        }
        return redirect('/all-fdr');
        // return redirect('/single-fdr/'.$fdr_id);
    }

    protected function maxId()
    {
        if (Instrument::count() == 0) return 0;
        return Instrument::max('id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FDRTable  $fDRTable
     * @return \Illuminate\Http\Response
     */
    public function show(FDRTable $fDRTable)
    {
        if (Auth::check()) {
            $a = FDRTable::orderBy('next_maturity')->whereDate('next_maturity', '<=', date('Y-m-d'))->where('status', 'verified')->get();
            $b = FDRTable::orderBy('next_maturity')->whereDate('next_maturity', '>', date('Y-m-d'))->where('status', 'verified')->get();
            $data = $b->merge($a);
            return view('all-fdr', ['data' => $data]);
        } else {
            return redirect('/login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FDRTable  $fDRTable
     * @return \Illuminate\Http\Response
     */
    public function edit(FDRTable $fDRTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FDRTable  $fDRTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FDRTable $fDRTable)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        FDRTable::find($request->input("fdr_id"))->update([
            "fdr_number" => $request->input("fdr_no"),
            "bank_name" => $request->input("bank_name"),
            "branch_name" => $request->input("branch_name"),
            "opening_amount" => $request->input("opening_amount"),
            "opening_date" => $request->input("open_date"),
            "period" => $request->input("period"),
            "next_maturity" => Carbon::createFromDate($request->input("closing_date")),
            "interest" => $request->input("interest"),
            "contact_person" => $request->input("contact_person"),
            "contact_number" => $request->input("contact_number")
        ]);

        Signatory::where('fdr_id', $request->input("fdr_id"))->delete();
        Notification::where('fdr_id', $request->input("fdr_id"))->delete();

        $data = $request->input();
        $fdr_id = $data["fdr_id"];
        $fdr_no = $data["fdr_no"];
        $files = $request->file();
        $db_files = Instrument::where('fdr_id', $data["fdr_id"])->orderBy('fdr_id')->get();

        foreach ($data as $key => $value) {
            if (substr($key, 0, 3) === "sig") {
                $signatory = new Signatory;
                $signatory->fdr_id = $fdr_id;
                $signatory->signatory = $value;
                $signatory->save();
                DB::commit();
            } else if (substr($key, 0, 4) === "date") {
                $ch = substr($key, -1);
                $notif = new Notification;
                $notif->fdr_id = $fdr_id;
                $notif->date = $value;
                $notif->time = $data['time' . $ch];
                $notif->recipient = $data['recipient' . $ch];
                $notif->save();
                DB::commit();

                DB::table('jobs')->delete();
                $recipients = explode(',', $notif->recipient);
                foreach ($recipients as $person) {
                    Mail::to($person)->later(Carbon::parse($value . " " . $data['time' . $ch]), new Remind($fdr_no, $data["bank_name"], $data["branch_name"], $data["closing_date"]));
                }
            } else if (substr($key, 0, 4) === "file") {
                $temp = explode("-", $key)[1];
                $action[$temp] = "preserve";
            }
        }

        //delete those db_files which are not marked as preserve
        foreach ($db_files as $key => $value) {
            if ($action[$value["id"]] != "preserve") {
                File::delete(public_path() . '/uploads/' . $value["new_file_name"]);
                Instrument::find($value["id"])->delete();
            }
        }

        for ($i = 0; $i < 5; $i++) {
            if (Arr::exists($data, "file" . $i)) {
                // reserve file in database and storage
            } else {
                if (Arr::exists($files, "file" . $i)) {
                    // add new file
                    $file = $request->file("file" . $i);
                    $oldFileName = $file->getClientOriginalName();

                    $instrument = new Instrument;
                    $instrument->fdr_id = $fdr_id;
                    $instrument->old_file_name = $oldFileName;
                    $newFileName = $fdr_no . "_" . $this->maxId() . "." . $file->getClientOriginalExtension();
                    $instrument->new_file_name = $newFileName;
                    $instrument->save();
                    $file->move('uploads/', $newFileName);
                    DB::commit();
                }
                /*if (count($db_files) > $i) {
                    // delete file pointed to $db_files[i]
                    $files_to_delete = $db_files[$i];
                    // delete from storage
                    File::delete(public_path() . '/uploads/' . $files_to_delete["new_file_name"]);
                    // delete from database
                    Instrument::where('id', $files_to_delete["id"])->delete();
                } else {
                    // No file came or went
                }*/
            }
        }

        return redirect('/single-fdr/' . $request->input("fdr_id"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FDRTable  $fDRTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(FDRTable $fDRTable)
    {
        //
    }
    public function renew(Request $request)
    {
        FDRTable::find($request->input('id'))->update([
            "period" => $request->input("period"),
            "next_maturity" => Carbon::createFromDate($request->input("new_maturity")),
            "contact_person" => $request->input("person"),
            "contact_number" => $request->input("number")
        ]);
        $fdr = FDRTable::find($request->input('id'));
        $tuple = new Renew;
        $tuple->fdr_id = $request->input('id');
        $tuple->renew_date = Carbon::createFromDate($request->input('renew_date'));
        $tuple->save();
        Mail::to($fdr->creator)->send(new Renewed($fdr->fdr_number, $fdr->bank_name, $fdr->branch_name));
        return redirect('/all-fdr');
    }
    public function notify()
    {
        $email = Auth::user()->email;
        $user = User::where('email', $email)->get();
        $user[0]->notify(new SendMail());
        return redirect('/add-fdr');
    }
}
