<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Analytics::fetchMostVisitedPages(Period::days(7), 20);
        dd($pages);
        return view('home');
    }

    public function getAnalyticsSummary(Request $request){
        $from_date = date("Y-m-d", strtotime($request->get('from_date',"7 days ago")));
        $to_date = date("Y-m-d",strtotime($request->get('to_date',$request->get('from_date','today')))) ; 
        $gAData = $this->gASummary($from_date,$to_date) ;
        dd($gAData);
        return $gAData;
    }
         //to get the summary of google analytics.
    private function gASummary($date_from,$date_to) {
        $service_account_email = 'service-account@fintech-159506.iam.gserviceaccount.com';       
        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Analytics Reporting");
        $analytics = new \Google_Service_Analytics($client);
        $cred = new \Google_Auth_AssertionCredentials(
            $service_account_email,
            array(\Google_Service_Analytics::ANALYTICS_READONLY),
              "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDAUT0xOyseXwTo\nMRchra9QmsRYGUZ8+rdGihcAXrt3AqDq4/sKRaIe5gvte+C3bwHV8fI42nz0axRN\n8WJo7lT7TzZweuAFTv+yuH/yHvNQlPAHMDCars7QTTGf8XcUHO5cq9yYA0FD2/gg\nWAwU9V34RjL0fvEFHPii9zOZoPMtrNsMwxQcKSw2cs9TZ+grwfp5r/pRbUbPlUYg\n/3B87jk5FjG9NKO7eRW2Pu7zf7pPZw067EMdAcGpZO7Gnzc21T1f3qj0JR0V7ooh\nQcxiGCUIUbkKMYOuj/Rb5uQhnfb8ERehxfGFAg9FSiYbPZqag2d/adbmt32hQEKW\nvud0nU4HAgMBAAECggEAHmy7wY4axDNEE3ewsSNJGPdjGIznGd6QIBi4itZx0eIY\nkxB+JqHdhAXg3TE728k0ASTFrTjji8dk7u/BIdiSmS9u7VyDFFPrH9sQYr2CwLzP\nPFPjXJVLIqkTsLoCnKv3CbIms+XP7WxfVL6ZKrempiB07zkl6CktLJrvDt7nmdH4\nevtrk7aKxpESJUQQVgs5CULH5gIQow/qx5rDHjAaLIsbIlmUXOBZQ4yO77/Lub8u\nZe6GDBZGeqHqA1yzKgYQiFu/TqAmtsNbtDYfm8dUY/Tkxv/RhJDCJRlpE7Vhq5zD\nBdrnjW/IWlMVZV0SFLgvkIZ8KMBhvJi6TARzhEXcAQKBgQDswarwvnXmbGCzi4Qh\ntJ84VeSqzOib4Gp4wzC5WyWHdQdgVb4Ob/HpI69zswwB112W7GbRy/eiUZz7Cg8Q\nak+3ZbIVeLTlNcJApa0sNEBft+ps7Ww9hajPpTOEhtuSQu9Hx5GXgj65a6a3l+gG\n9DPGkZC0dLXMrSgWDFZMmtLtPQKBgQDP8uYyy3mhg9owkAhgr1gdSdLJxQ/13o+Y\nozOWHvBjoF84k/0iLDOqGxuqwBaZBf1ov5W9TS4CeyEfECaCSYc87gThcsKngeZM\n2fSICIkmOHh24WXamEENQqmKvMXQ8g9HGKzo0TL+r9/iDrrsfo0nCPVEC2A/QBU9\nBB5YQ9SkkwKBgQDDXSAwXgmt5Vp6bbLPmVsVQpNZeZKsJafWFMMdAKBcQW6fyMD2\n6tsE1cSOxX0v+8YnptVFY3jpQU03PdqmYgN7w3gLDbq/tPehHtViN4+zLHFOBzCd\nJ7Df/2MehaWj8IXAhmaWTgxyNumwb7IwIsyimzV8Ix5tUalVYELKHavVxQKBgCkO\nMMq4h4QO7yYFWdIU7FWj/Jzfbj5BuaIOHqI164oP4JzgAusbRPwBrB2zHQMLPrPO\nl3avZTUSMEDcxG2WrL+n0ojcSngd2mUz5uZwoPtNzOLTr3NP+g/vKF/+0yNklwWX\nZpP0sZe9C3urItaMSbv6NcpAYLk8IrVQOdl9Ut9HAoGACt0YP/MLOlnn/S/qyn5+\npQhuIsnv3rNa7yZrhfn0u+jdLNk4ubmc/A6Z4Yc/hqQEV/UOwfSwAAlHAZgdUWYi\nvL6VfVaDxX5goKnWxnuvErFH1Zg+3Lem+moBzXXpb0EPxMXsAgXWe6j8YuZReXXu\nOLoW4l5DW4h2ZmxxWr/D/Jc=\n-----END PRIVATE KEY-----\n"
        );     
        $client->setAssertionCredentials($cred);
        if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $optParams = [
            'dimensions' => 'ga:date',
            'sort'=>'-ga:date'
        ] ;       
        $results = $analytics->data_ga->get(
           'ga:140884579',
           $date_from,
           $date_to,
           'ga:sessions,ga:users,ga:pageviews,ga:bounceRate,ga:hits,ga:avgSessionDuration',
           $optParams
           );
            
            $rows = $results->getRows();
            $rows_re_align = [] ;
            foreach($rows as $key=>$row) {
                foreach($row as $k=>$d) {
                    $rows_re_align[$k][$key] = $d ;
                }
            }           
            $optParams = array(
                        'dimensions' => 'rt:medium'
                );
            try {
              $results1 = $analytics->data_realtime->get(
                  'ga:140884579',
                  'rt:activeUsers',
                  $optParams);
              // Success. 
            } catch (apiServiceException $e) {
              // Handle API service exceptions.
              $error = $e->getMessage();
            }
            $active_users = $results1->totalsForAllResults ;
            return [
                'data'=> $rows_re_align ,
                'summary'=>$results->getTotalsForAllResults(),
                'active_users'=>$active_users['rt:activeUsers']
                ] ;
    }

     public function getGA(Request $request){
        // OAuth2 service account p12 key file
        $p12FilePath = storage_path('fintech-ee34a09820c7.p12');

        // OAuth2 service account ClientId
        $serviceClientId = '455664926333-inmsn3c3g9m18s553clrh770bgoq505t.apps.googleusercontent.com';

        // OAuth2 service account email address
        $serviceAccountName = 'google-api@fintech-159506.iam.gserviceaccount.com';

        // Scopes we're going to use, only analytics for this tutorial
        $scopes = array(
            'https://www.googleapis.com/auth/analytics.readonly'
        );

        $googleAssertionCredentials = new \Google_Auth_AssertionCredentials(
            $serviceAccountName,
            $scopes,
            file_get_contents($p12FilePath)
        );

        $client = new \Google_Client();
        $client->setAssertionCredentials($googleAssertionCredentials);
        $client->setClientId($serviceClientId);
        $client->setApplicationName("Project");

        // Create Google Service Analytics object with our preconfigured Google_Client
        $analytics = new \Google_Service_Analytics($client);

        // Add Analytics View ID, prefixed with "ga:"
        $analyticsViewId    = 'ga:140884579';

        $startDate          = '2017-02-20';
        $endDate            = '2017-02-22';
        $metrics            = 'ga:sessions,ga:pageviews';

        $data = $analytics->data_ga->get($analyticsViewId, $startDate, $endDate, $metrics, array(
            'dimensions'    => 'ga:pagePath',
            // 'filters'       => 'ga:pagePath==/url/to/product/',
            'sort'          => '-ga:pageviews',
        ));

        // Data 
        $items = $data->getRows();
        dd($items);
    }   
}
