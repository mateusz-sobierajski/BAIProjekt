<?php

class RateLimiter {
    private $limit;
    private $timeFrame;
    private $file;

    public function __construct($limit, $timeFrame) {
        $this->limit = $limit; 
        $this->timeFrame = $timeFrame; 
        $this->file = 'rate_limiter_data.json'; 
    }

    public function isAllowed($ip) {
        $data = $this->getData();

        if (!isset($data[$ip])) {
            $data[$ip] = [
                'count' => 1,
                'timestamp' => time()
            ];
            $this->saveData($data);
            return true;
        }

        if (time() - $data[$ip]['timestamp'] > $this->timeFrame) {
            $data[$ip] = [
                'count' => 1,
                'timestamp' => time()
            ];
            $this->saveData($data);
            return true;
        }

        if ($data[$ip]['count'] >= $this->limit) {
            return false;
        }

        $data[$ip]['count']++;
        $this->saveData($data);
        return true;
    }

    private function getData() {
        if (!file_exists($this->file)) {
            return [];
        }
        $json = file_get_contents($this->file);
        return json_decode($json, true);
    }

    private function saveData($data) {
        $json = json_encode($data);
        file_put_contents($this->file, $json);
    }
}
?>
