<?php

namespace kirpykla_dev\Controllers;

use \GuzzleHttp\Client as HttpClient;
use Codepunker\InvoicesApp\Models\InvoicesModel as InvoicesModel;

//shows some data on the homepage
class HomeController extends BaseController
{
    public function __construct(array $views)
    {
        $this->getHomePageData();
        parent::__construct($views);
    }

//retrieve data from remote endpoint and store it using the model
    private function getHomePageData()
    {
        $client = new HttpClient();
        try {
            $res = $client->request('GET', 'https://www.remoteendpoint.com', [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($res->getBody());
            $model = new InvoicesModel($data);
            $model->store();
            return $data;
        } catch (Exception $e) {
            echo "Sorry for the inconvenience";
        }
    }
}
