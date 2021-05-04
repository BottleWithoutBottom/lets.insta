<?

namespace LetsInstagram\Lib;

class RequestBuilder {
    protected $request = '';
    protected $response = '';

    public function getRequest()
    {
        return $this->request;
    }

    public function concat($string)
    {
        $this->request .= $string;
        return true;
    }

    public function sendRequest()
    {
        $curl_connection = curl_init();
        curl_setopt($curl_connection, CURLOPT_URL, $this->getRequest());
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, 1);
        $this->setResponse(curl_exec($curl_connection));
        return $this;
    }

    public function setResponse($response)
    {
        $this->response = $response;
        return true;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function drop()
    {
        $this->request = '';
        $this->setResponse('');
        return true;
    }

}
