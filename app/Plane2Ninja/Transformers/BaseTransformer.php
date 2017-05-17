<?php

namespace App\Plane2Ninja\Transformers;
use App\Models\Client;
use Carbon\Carbon;

/**
 * Class BaseTransformer.
 */
class BaseTransformer
{

    public function __construct()
    {
    }


    /**
     * @param $data
     * @param $field
     *
     * @return string
     */
    public function getString($data)
    {
        return isset($data) ? $data : '';
    }
    /**
     * @param $data
     * @param $field
     *
     * @return int
     */
    public function getNumber($data, $field)
    {
        return (isset($data->$field) && $data->$field) ? $data->$field : 0;
    }
    /**
     * @param $data
     * @param $field
     *
     * @return float
     */
    public function getFloat($data)
    {
        return (isset($data)) ? $this->parseFloat($data) : 0;
    }


    /**
     * @param $date
     * @param string $format
     * @param mixed  $data
     * @param mixed  $field
     *
     * @return null
     */
    public function getDate($datefield)
    {
        $date = null;

        if ($datefield) {
            try {
                $date = new Carbon($datefield);
            } catch (Exception $e) {
                // if we fail to parse return blank
            }
        }
        return $date ? $date->format('Y-m-d') : null;
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getInvoiceNumber($number)
    {
        return str_pad(trim($number), 4, '0', STR_PAD_LEFT);
    }

    public static function parseFloat($value)
    {
        $value = preg_replace('/[^0-9\.\-]/', '', $value);

        return floatval($value);
    }

    public function formatNotes($notes)
    {
        $formattedString = null;

        foreach($notes as $note)
            $formattedString .= $this->getDate($note->date) . " - " . $note->client_note . "\n]n";

        return $formattedString;
    }

    public function getContactPhone(Client $client) {

        if(isset($client->client_phone))
            return $client->client_phone;
        elseif(isset($client->client_mobile))
            return $client->client_mobile;
        else
            return 'no phone number set';
    }


}