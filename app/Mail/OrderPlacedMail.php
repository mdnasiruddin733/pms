<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data,$order;
    public function __construct($data,$order)
    {
        $this->data=$data;
        $this->order=$order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $pdf=Pdf::loadView("pdf.invoice",["order_details"=>$this->order->details]);
        return $this->markdown('mail.order-placed-mail',["data"=>$this->data])->attachData($pdf->output(),"invoice.pdf",["mime"=>"application/pdf"]);
    }
}
