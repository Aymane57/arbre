<?php

class Object {

    private $id;
    private $id_parent;
    private $code;

    function __construct(array $data) {
        # Instancie un objet à partir d'un tableau
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getId_parent() {
        return $this->id_parent;
    }

    public function getCode() {
        return $this->code;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setId_parent($id_parent) {
        $this->id_parent = $id_parent;
    }

    public function setCode($code) {
        $this->code = $code;
    }

}
