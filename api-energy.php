<?php

//===============================[API cals Electrcité]===============================//
function AllCalsElec() {
        function ElecCals($year, $month, $day, $calAnnee, $symbole)
        {

            $url = "https://webservice-eex.gvsi.com/query/json/getDaily/close/offexchtradevolumeeex/onexchtradevolumeeex/tradedatetimegmt/?priceSymbol=%22%2FE.F7" . $symbole . "YF" . $calAnnee . "%22&chartstartdate=2022%2F01%2F01&chartstopdate=" . $year . "%2F" . $month . "%2F" . $day . "&dailybarinterval=Days&aggregatepriceselection=First";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $headers = array(
                "Referer: https://www.eex.com/",
                "Content-Type: application/x-www-form-urlencoded",
                "Content-Length: 0",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $resp = curl_exec($curl);
            curl_close($curl);
            $EexData = (json_decode($resp)
                    ->results
                    ->items);
                return $EexData;

            }
            #---------------------------------#
            $Base23 = ElecCals(Date('Y'), Date('m'), Date('d'), 23, 'B');
        $Base24 = ElecCals(Date('Y'), Date('m'), Date('d'), 24, 'B');
        $Base25 = ElecCals(Date('Y'), Date('m'), Date('d'), 25, 'B');
        #---------------------------------#
        $Base23all = json_encode($Base23);
        $Base24all = json_encode($Base24);
        $Base25all = json_encode($Base25);
        #---------------------------------#
        $Base23last = end($Base23)->close;
        $Base24last = end($Base24)->close;
        $Base25last = end($Base25)->close;
        #---------------------------------#
        $Peak23 = ElecCals(Date('Y'), Date('m'), Date('d'), 23, 'B');
        $Peak24 = ElecCals(Date('Y'), Date('m'), Date('d'), 24, 'B');
        $Peak25 = ElecCals(Date('Y'), Date('m'), Date('d'), 25, 'B');
        #---------------------------------#
        $Peak23all = json_encode($Peak23);
        $Peak24all = json_encode($Peak24);
        $Peak25all = json_encode($Peak25);
        #---------------------------------#
        $Peak23last = end($Peak23)->close;
        $Peak24last = end($Peak24)->close;
        $Peak25last = end($Peak25)->close;

        return ([

            "Cals_Baseload" => [

                "Base23last" => $Base23last,
                "Base24last" => $Base24last,
                "Base25last" => $Base25last,
                "Base23all" => $Base23all,
                "Base24all" => $Base24all,
                "Base25all" => $Base25all,

            ],
            "Cals_Peakload" => [

                "Peak23last" => $Peak23last,
                "Peak24last" => $Peak24last,
                "Peak25last" => $Peak25last,
                "Peak23all" => $Peak23all,
                "Peak24all" => $Peak24all,
                "Peak25all" => $Peak25all,

            ],

        ]);

}

 
//===============================[API Electrcité]==========================//

function electrcity()
    {
        $url  = "https://www.epexspot.com/en/market-data?ajax_form=1&_wrapper_format=html&_wrapper_format=drupal_ajax";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        #----------------------------------#

        $headers = array(
            "Connection: keep-alive",
            "Content-Type: application/x-www-form-urlencoded",
            "Host: www.epexspot.com",
            "Referer: https://www.epexspot.com/en/market-data?market_area=AT&trading_date=" . Date('Y-m-d') . "&delivery_date=" . Date('Y-m-d', strtotime("+1 day")) . "&underlying_year=&modality=Auction&sub_modality=DayAhead&product=60&data_mode=graph&period=month",
            "ajax_form: 1",
            "_wrapper_format: drupal_ajax",
        );

        #----------------------------------#

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "filters%5Bmodality%5D=Auction&filters%5Bsub_modality%5D=DayAhead&filters%5Btrading_date%5D=" . Date('d') . "%20" . Date('M') . ".%20" . Date('Y') . "&filters%5Bdelivery_date%5D=" . Date('d', strtotime("+1 day")) . "%20" . Date('M') . ".%20" . Date('Y') . "&filters%5Bproduct%5D=60&filters%5Bdata_mode%5D=graph&filters%5Bmarket_area%5D=AT&filters%5Bperiod%5D=year&triggered_element=filters%5Bdata_mode%5D&first_triggered_date=&form_build_id=form-PtdHvSGPvXq4x0229zJXzzvgM0b6FfyjO2BZWzc6oAY&form_id=market_data_filters_form&_triggering_element_name=submit_js&_triggering_element_value=&_drupal_ajax=1&ajax_page_state%5Btheme%5D=epex&ajax_page_state%5Btheme_token%5D=&ajax_page_state%5Blibraries%5D=bootstrap%2Fpopover%2Cbootstrap%2Ftooltip%2Ccore%2Fhtml5shiv%2Ccore%2Fjquery.form%2Cepex%2Fglobal-scripts%2Cepex%2Fglobal-styling%2Cepex_core%2Fdata-disclaimer%2Cepex_market_data%2Fauc_status%2Cepex_market_data%2Ffilters%2Cepex_market_data%2Fgraphs%2Cepex_market_data%2Fmap%2Cepex_market_data%2Ftables%2Ceu_cookie_compliance%2Feu_cookie_compliance_default%2Cstatistics%2Fdrupal.statistics%2Csystem%2Fbase";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);

        #----------------------------------#


        $energyData     = json_decode(json_decode($resp)[0]->settings->charts->price);
        $PeakloadActuel = $energyData[2]->data;
        $BaseloadActuel = $energyData[1]->data;
        $BaseloadElec   = [];
        $PeakloadElec   = [];
        $DatesElec      = [];
        $lastElecPriceBase = json_encode(end($PeakloadActuel)->y)." €/Mkw";
        $lastElecPricePeak = json_encode(end($BaseloadActuel)->y)." €/Mkw";
        $lastElecDatePeak  = json_encode(end($DatesElec));

        #----------------------------------#


        for ($base = 0; $base < count($BaseloadActuel); $base++) {
            array_push($BaseloadElec, $energyData[1]->data[$base]->y);
            array_push($PeakloadElec, $energyData[2]->data[$base]->y);
            $PowerDate = $energyData[2]->data[$base]->x;
            $PowerDate = substr($PowerDate, 0, 10);
            $PowerDate = "'" . date("r", $PowerDate) . "'";
            array_push($DatesElec, $PowerDate);
        }

        #----------------------------------#

        $RawDataPeakload = json_encode($energyData[2]->data);
        $RawDataPeaklaod = json_encode($energyData[1]->data);
        $Baseload = json_encode($BaseloadElec);
        $Peakload = json_encode($PeakloadElec);
        $cloture_Date = json_encode($DatesElec);

         #----------------------------------#

        return ([
            "lastClosureDate"=>$lastElecDatePeak,
            "lastBaseload"=> $lastElecPriceBase,
            "lastPeaload"=> $lastElecPriceBase,
            "BaseloadFull" => $RawDataPeakload,
            "PeakloadFull" => $RawDataPeaklaod,
            "BaseloadFiltred" => $Baseload,
            "PeakloadFiltred" => $Peakload,
            "HorodatageFiltred" => $cloture_Date
        ]) ;
}

 


//===============================[API cals Gaz]=================================//

function natural_gaz_cals()
    {
        $url = "https://www.powernext.com/table-feed/132995/772/516";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Content-Length: 0",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);

        $scratchGaz = json_decode($response)->html;

        $t = str_replace(',,', ',', preg_replace('/(\d{4}[-][01]\d[-][0-3]\d)/', '', str_replace('                   ', '', str_replace(',Trading Day,Season+1,Season+2,Season+3,Season+4,Calendar+1,Calendar+2,Calendar+3,,     ', '', str_replace(',,', ',', str_replace('                       ', ',', strip_tags($scratchGaz)))))));
        $t = str_replace(',,', ',', str_replace('                   ', '', str_replace(',Trading Day,Season+1,Season+2,Season+3,Season+4,Calendar+1,Calendar+2,Calendar+3,,     ', '', str_replace(',,', ',', str_replace('                       ', ',', strip_tags($scratchGaz))))));
        $t = substr($t, 1);
        $t = rtrim($t, ', ');
        $t = str_replace('Calendar+1', ' ', $t);
        $t = str_replace('Calendar+2', ' ', $t);
        $t = str_replace('Calendar+3', ' ', $t);
        $t = str_replace('Season+4', ' ', $t);
        $t = str_replace('Season+3', ' ', $t);
        $t = str_replace('Season+2', ' ', $t);
        $t = str_replace('Season+1', ' ', $t);
        $t = str_replace(', Trading Day', ' ', $t);
        $t = str_replace('           ', ' ', $t);
        $t = str_replace(",,", ' ', $t);
        $t = str_replace(" ", ',', $t);
        $t = str_replace(",,,", ',', $t);
        $t = str_replace(",,,", ',', $t);
        $t = str_replace(",,", ',', $t);
        $t = str_replace(",\n,", ',', $t);
        $t = str_replace(",\n,", ',', $t);
        $t = str_replace(",\n,", ',', $t);
        $t = str_replace(",\n,", ',', $t);
        $t = str_replace(",\n,", ',', $t);
        $t = str_replace(",\n,", ',', $t);
        $t = str_replace(",\n\n,", ',', $t);
        $t = trim(str_replace(",,", ', ', $t));
        $t = str_replace(",, ", ',', $t);
        $t = str_replace("\n,", ',', $t);
        $t = rtrim($t, '\n, ');
        $t = substr($t, 1);
        $t = [explode(',', $t)];

        $date_Gaz_Eex = [];
        $Calendrier1  = [];
        $Calendrier2  = [];
        $Calendrier3  = [];
        $Season1      = [];
        $Season2      = [];
        $Season3      = [];
        $Season4      = [];

        for ($date = 0; $date < count($t[0]); $date = $date + 8) {
            array_push($date_Gaz_Eex, $t[0][$date]);
            array_push($Calendrier1, intval($t[0][$date + 5]));
            array_push($Calendrier2, intval($t[0][$date + 6]));
            array_push($Calendrier3, intval($t[0][$date + 7]));
            array_push($Season1, intval($t[0][$date + 1]));
            array_push($Season2, intval($t[0][$date + 2]));
            array_push($Season3, intval($t[0][$date + 3]));
            array_push($Season4, intval($t[0][$date + 4]));
        }

        $Calendrier1  = array_reverse($Calendrier1);
        $Calendrier2  = array_reverse($Calendrier2);
        $Calendrier3  = array_reverse($Calendrier3);
        $date_Gaz_Eex = array_reverse($date_Gaz_Eex);

        $Season1 = array_reverse($Season1);
        $Season2 = array_reverse($Season2);
        $Season3 = array_reverse($Season3);
        $Season4 = array_reverse($Season4);

        return json_encode([
            "Calendriers" => [
                "Gaz_lastCal_1" => end($Calendrier1),
                "Gaz_lastCal_2" => end($Calendrier2),
                "Gaz_lastCal_3" => end($Calendrier3),
                "Gaz_Cals_1" => $Calendrier1,
                "Gaz_Cals_2" => $Calendrier2,
                "Gaz_Cals_3" => $Calendrier3,
            ],
            'seasons' => [
                "lastSeason1" => end($Season1),
                "lastSeason2" => end($Season2),
                "lastSeason3" => end($Season3),
                "lastSeason4" => end($Season4),
                "Season1" => $Season1,
                "Season2" => $Season2,
                "Season3" => $Season3,
                "Season4" => $Season4, ]
        ]
        );
}


//===============================[API Gaz]==================================//


function gaz()
    {
        $url  = "https://www.powernext.com/data-feed/132740/150/516";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Content-Length: 0",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $GazData = json_decode($resp)->values[0]->data;

        $prices = [];
        $dates  = [];
        $yearly = [];

        foreach ($GazData as $element) {
            array_push($prices, $element->y);
            $GazDate = $element->x; $GazDate = substr($GazDate, 0, 10); $GazDate = "'" . date("r", $GazDate) . "'";
            array_push($dates, $GazDate);
            array_push($yearly, $element->name);
        }

        $maxPrice  = max($prices);
        $avgPrice  = array_sum($prices) / count($prices);
        $minPrice  = min($prices);
        $lastPrice = end($prices);
        $prices    = json_encode($prices);
        $dates     = json_encode($dates);
        $yearly    = $yearly;

        return ([
            'baseload_gaz' => $lastPrice,
            'max_price' => $maxPrice,
            'min_price' => $minPrice,
            'avg_price' => $avgPrice,
            'prices' => $prices,
            'dates' => $dates,
            'date_yearly' => $yearly

        ]);
}

 
//===============================[Drivers]======================================//
 
function fullDrivers()
    {
        function drivers($symbole)
        {
            $url = "https://www.theice.com/marketdata/DelayedMarkets.shtml?getHistoricalChartDataAsJson=&marketId=$symbole&historicalSpan=1";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);

            return json_decode($resp);
        }
        $Dyoxide  = drivers(5474736); // id = 5474736;
        $lastCo2  = end($Dyoxide->bars)[1];
        $list_Co2 = json_encode($Dyoxide->bars);

        $Coal      = drivers(5310588); // id = 5310588
        $lastCoal  = end($Coal->bars)[1];
        $list_Coal = json_encode($Coal->bars);

        $Petrole      = drivers(5166943); // id = 5166943
        $lastPetrole  = end($Petrole->bars)[1];
        $list_Petrole = json_encode($Petrole->bars);

        return ([
            "CO2" => [
                "list" => $Dyoxide,
                "last" => $lastCo2,
                'Co2_json' => $list_Co2,

            ],
            "CHARBON" => [
                "list" => $Coal,
                "last" => $lastCoal,
                'Charbon_json' => $list_Coal,

            ],
            "CHARBON" => [
                "list" => $Petrole,
                "last" => $lastPetrole,
                'Petrole_json' => $list_Petrole,

            ]
        ]);

}


 

//===============================[Energy News]======================================//

function EnergyNews(){

    $curl = curl_init();

    curl_setopt_array($curl, 
          [
            CURLOPT_URL => "https://free-news.p.rapidapi.com/v1/search?q=CO2%2C%20P%C3%A9trole%2C%20Charbon&lang=fr", 
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_FOLLOWLOCATION => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_SSL_VERIFYHOST => false, 
            CURLOPT_SSL_VERIFYPEER => false, 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 30, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: free-news.p.rapidapi.com", 
                "X-RapidAPI-Key: a76be59b22msha21a0b1d33c9faap1a235bjsneb32dc3d1ace"
                            ], 
            ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $News_Energy = json_decode($response);

    return $News_Energy;
}

#|------------------------------------[DATA HUB]------------------------------|#
/*-----|----*/                                                   /*-----|----*/ 
/*-----|----*/      $BasicDataNews = json_encode(EnergyNews());  /*-----|----*/      
/*-----|----*/      //print_r($BasicDataNews)                    /*-----|----*/                        
/*-----|----*/      $Drivers = fullDrivers();                    /*-----|----*/               
/*-----|----*/      // print_r($Drivers);                        /*-----|----*/           
/*-----|----*/      $Gaz = gaz();                                /*-----|----*/   
/*-----|----*/      // print_r(json_encode($Gaz));               /*-----|----*/                    
/*-----|----*/      $BasicGazCalsData = electrcity()             /*-----|----*/                      
/*-----|----*/      // print_r(natural_gaz_cals());              /*-----|----*/                     
/*-----|----*/      $BasicElecData = electrcity();               /*-----|----*/                    
/*-----|----*/      // print_r($BasicElecData);                  /*-----|----*/                 
/*-----|----*/      $EleCals = AllCalsElec();                    /*-----|----*/               
/*-----|----*/      // print_r($EleCals) ;                       /*-----|----*/   
/*-----|----*/                                                   /*-----|----*/ 
#|----------------------------------------------------------------------------|#         


?>


 
