<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Remind extends Mailable
{
    use Queueable, SerializesModels;
    protected $fdr_no, $bank, $branch, $mature_date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fdr_no, $bank, $branch, $mature_date)
    {
        $this->fdr_no = $fdr_no;
        $this->bank = $bank;
        $this->branch = $branch;
        $this->mature_date = $mature_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name3')->with([
            "fdr_no" => $this->fdr_no,
            "bank" => $this->bank,
            "branch" => $this->branch,
            "last_date" => $this->mature_date,
        ]);
    }
}
