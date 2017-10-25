<?php

class Ready {

    private $source = '';
    private $destination = '';
    private $seat = '';

    function __construct($source, $destination, $seat) {
        $this->source = $source;
        $this->destination = $destination;
        $this->seat = $seat;
    }

    public static function source($obj) {
        return $obj->source;
    }

    public static function destination($obj) {
        return $obj->destination;
    }

    public static function seat($obj) {
        return $obj->seat;
    }

    
    
    
    
    
    
    
    
    
    
    
    
}

class Train extends Ready {

    private $train;

    function __construct($source, $destination, $seat, $train) {

        
        parent::__construct($source, $destination, $seat);
        $this->train = $train;
    }

    public function ok() {

        return 'Train ' . $this->train . ' From ' . Ready::source($this) . ' To ' . Ready::destination($this) . '. Seat ' . Ready::seat($this) . '.';
    }

    
    
    
}

class Bus extends Ready {

    function __construct($source, $destination, $seat = null) {
        parent::__construct($source, $destination, $seat);
    }

    
    
    
    
    
    
    
    
    public function ok() {

        return 'Bus From ' . Ready::source($this) . ' To ' . Ready::destination($this) . '. ' . (Ready::seat($this) ? ' Seat ' . Ready::seat($this) . '.' : NULL);
    }

}

class Airplane extends Ready {

    private $airplane, $gate, $X;

    function __construct($source, $destination, $seat, $airplane, $gate, $X = null) {

        parent::__construct($source, $destination, $seat);
        $this->airplane = $airplane;
        $this->gate = $gate;
        $this->counter = $X;
    }

    public function ok() {
        return 'Airplane ' . $this->airplane . ' To ' . Ready::destination($this) . '. Gate ' . $this->gate . ', Seat ' . Ready::seat($this) . '. ' . ($this->counter ? 'Your Baggage Is At Counter ' . $this->counter . '.' : 'Baggage Transferred.');
    }

}

class Sorter {

    private $arrivalIndex = array();
    private $departureIndex = array();

    function __construct($ticket) {
        $this->ticket = $ticket;
    }

    public function sort() {

        self::indexer();

        $startingPoint = self::getstartingPoint();

        $sortedTickets = array();
        $currentLocation = $startingPoint;

        while ($Ready = (array_key_exists($currentLocation, $this->departureIndex)) ? $this->departureIndex[$currentLocation] : null) {

            array_push($sortedTickets, $Ready);

            $currentLocation = Ready::destination($Ready);
        }

        return $sortedTickets;
        
    }

    function indexer() {
        for ($X = 0; $X < count($this->ticket); $X++) {

            $Ready = $this->ticket[$X];

            $this->departureIndex[Ready::source($Ready)] = $Ready;
            $this->arrivalIndex[Ready::destination($Ready)] = $Ready;
        }
    }

    private function getstartingPoint() {
        for ($X = 0; $X < count($this->ticket); $X++) {

            $source = Ready::source($this->ticket[$X]);

            if (!array_key_exists($source, $this->arrivalIndex)) {

                return $source;
            }
        }
        return null;
    }
    
    
    
    
    
    
    
    
    
    

}

class Trip {

    public function __construct($ticket) {
        
        $this->ticket = $ticket;

        $ticket = new Sorter($this->ticket);

        $this->ticket = $ticket->sort(); 
    }

    public function result() {

        $Final= "";
        for ($X = 0; $X < count($this->ticket); $X++) {
            $currentPass = $this->ticket[$X];

            $Final .= '' . $currentPass->ok() . '</br>';
        }
        $Final.='Thank You';
        return $Final;
    }

}









$go = new Trip([
    new Bus('Barcelona', 'Gerona Airport'),
    new Airplane('Stockholm', 'New York JFK', '7B', 'SK22', '22'),
    new Train('Madrid', 'Barcelona', '45B', '78A'),
    new Airplane('Gerona Airport', 'Stockholm', '3A', 'SK455', '45B', '344')
        ]);
echo '#####################################TEST##################################<br//>';
echo $go->result();
