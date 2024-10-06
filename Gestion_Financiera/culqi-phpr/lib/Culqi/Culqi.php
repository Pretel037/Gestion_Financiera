<?php
namespace Culqi;

use Culqi\Error as Errors;
/**
 * Class Culqi
 *
 * @package Culqi
 */
class Culqi
{
    public $api_key;
    public $Tokens;
    public $Charges;
    public $Subscriptions;
    public $Refunds;
    public $Plans;
    public $Transfers;
    public $Iins;
    public $Cards;
    public $Events;
    public $Customers;
    public $Orders;

    /**
    * La versión de API usada
    */
    const API_VERSION = "v2.0";
    /**
     * La URL Base por defecto
     */
    const BASE_URL = "https://api.culqi.com/v2";

    /**
     * URL alternativa (segura)
     */ 
    const SECURE_BASE_URL = "https://secure.culqi.com/v2"; 

    /**
     * Library version
     */ 
    const CULQI_CLIENT = "PHP"; 
    const CULQI_CLIENT_VERSION = "2.0.3";

    const X_API_VERSION = "2";
    

    /**
     * Constructor.
     *
     * @param array|null $options
     *
     * @throws Error\InvalidApiKey
     *
     * @example array('api_key' => "{api_key}")
     *
     */
    public function __construct($options)
    {
        $this->api_key = $options["api_key"];
        $this->Tokens = new Tokens($this);
        $this->Charges = new Charges($this);
        $this->Subscriptions = new Subscriptions($this);
        $this->Refunds = new Refunds($this);
        $this->Plans = new Plans($this);
        $this->Transfers = new Transfers($this);
        $this->Iins = new Iins($this);
        $this->Cards = new Cards($this);
        $this->Events = new Events($this);
        $this->Customers = new Customers($this); 
        $this->Orders = new Orders($this);
    }
}
