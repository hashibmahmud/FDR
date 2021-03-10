<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FDRCreated extends Mailable
{
    use Queueable, SerializesModels;
    protected $fdr_no, $bank, $branch;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fdr_no, $bank, $branch)
    {
        $this->fdr_no = $fdr_no;
        $this->bank = $bank;
        $this->branch = $branch;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name')->with([
            "fdr_no" => $this->fdr_no,
            "bank" => $this->bank,
            "branch" => $this->branch,
        ]);
    }
}
