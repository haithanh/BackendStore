<?php

namespace App\Jobs;

use App\Mail\BanReward;
use App\Mail\ExceptionOccured;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $_aEmail = "";
    private $_aData = "";
    private $_iType = 0;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($iType, $anyEmail, $aData)
    {
        $this->_iType = $iType;
        if (is_string($anyEmail))
        {
            $this->_aEmail = explode(",", $anyEmail);
        }
        for ($i = 0; $i < count($this->_aEmail); $i++)
        {
            $this->_aEmail[$i] = trim($this->_aEmail[$i]);
        }
        $this->_aData = $aData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $oEmail  = null;
        $subject = '';
        if ($this->_iType == MAIL_TYPE_ERROR_EXCEPTION)
        {
            if (isset($this->_aData["content"]) && strlen(trim($this->_aData["content"])) > 0)
            {
                $subject = '';
                $oEmail = new ExceptionOccured($this->_aData["content"]);
            }
        }
        else if ($this->_iType == MAIL_TYPE_BAN_REWARD)
        {
            if (isset($this->_aData["game"])
                && isset($this->_aData["display_name"])
                && isset($this->_aData["uid"]))
            {
                $oEmail = new BanReward($this->_aData["game"], $this->_aData["display_name"], $this->_aData["uid"]);
            }
        }
        if (!empty($oEmail))
        {
            \Mail::to($this->_aEmail)->send($oEmail);
        }
    }
}
