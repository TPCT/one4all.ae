<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class TradingViewIndicators
{
    public const ONE_MINUTE = "site.ONE_MINUTE";
    public const FIFTEEN_MINUTES = "site.FIFTEEN_MINUTES";
    public const ONE_HOUR = "site.ONE_HOUR";
    public const FOUR_HOURS = "site.FOUR_HOURS";
    public const ONE_DAY = "site.ONE_DAY";
    public const ONE_WEEK = "site.ONE_WEEK";
    public const ONE_MONTH = "site.ONE_MONTH";

    public static function get_data($stamp, $currency_code){
        $stamps = [
            __(self::ONE_MINUTE) => [
                'fields' => 'Recommend.Other|1,Recommend.All|1,Recommend.MA|1,RSI|1,RSI[1]|1,Stoch.K|1,Stoch.D|1,Stoch.K[1]|1,Stoch.D[1]|1,CCI20|1,CCI20[1]|1,ADX|1,ADX+DI|1,ADX-DI|1,ADX+DI[1]|1,ADX-DI[1]|1,AO|1,AO[1]|1,AO[2]|1,Mom|1,Mom[1]|1,MACD.macd|1,MACD.signal|1,Rec.Stoch.RSI|1,Stoch.RSI.K|1,Rec.WR|1,W.R|1,Rec.BBPower|1,BBPower|1,Rec.UO|1,UO|1,EMA10|1,close|1,SMA10|1,EMA20|1,SMA20|1,EMA30|1,SMA30|1,EMA50|1,SMA50|1,EMA100|1,SMA100|1,EMA200|1,SMA200|1,Rec.Ichimoku|1,Ichimoku.BLine|1,Rec.VWMA|1,VWMA|1,Rec.HullMA9|1,HullMA9|1,Pivot.M.Classic.R3|1,Pivot.M.Classic.R2|1,Pivot.M.Classic.R1|1,Pivot.M.Classic.Middle|1,Pivot.M.Classic.S1|1,Pivot.M.Classic.S2|1,Pivot.M.Classic.S3|1,Pivot.M.Fibonacci.R3|1,Pivot.M.Fibonacci.R2|1,Pivot.M.Fibonacci.R1|1,Pivot.M.Fibonacci.Middle|1,Pivot.M.Fibonacci.S1|1,Pivot.M.Fibonacci.S2|1,Pivot.M.Fibonacci.S3|1,Pivot.M.Camarilla.R3|1,Pivot.M.Camarilla.R2|1,Pivot.M.Camarilla.R1|1,Pivot.M.Camarilla.Middle|1,Pivot.M.Camarilla.S1|1,Pivot.M.Camarilla.S2|1,Pivot.M.Camarilla.S3|1,Pivot.M.Woodie.R3|1,Pivot.M.Woodie.R2|1,Pivot.M.Woodie.R1|1,Pivot.M.Woodie.Middle|1,Pivot.M.Woodie.S1|1,Pivot.M.Woodie.S2|1,Pivot.M.Woodie.S3|1,Pivot.M.Demark.R1|1,Pivot.M.Demark.Middle|1,Pivot.M.Demark.S1|1'
            ],
            __(self::FIFTEEN_MINUTES) => [
                'fields' => 'Recommend.Other|15,Recommend.All|15,Recommend.MA|15,RSI|15,RSI[1]|15,Stoch.K|15,Stoch.D|15,Stoch.K[1]|15,Stoch.D[1]|15,CCI20|15,CCI20[1]|15,ADX|15,ADX+DI|15,ADX-DI|15,ADX+DI[1]|15,ADX-DI[1]|15,AO|15,AO[1]|15,AO[2]|15,Mom|15,Mom[1]|15,MACD.macd|15,MACD.signal|15,Rec.Stoch.RSI|15,Stoch.RSI.K|15,Rec.WR|15,W.R|15,Rec.BBPower|15,BBPower|15,Rec.UO|15,UO|15,EMA10|15,close|15,SMA10|15,EMA20|15,SMA20|15,EMA30|15,SMA30|15,EMA50|15,SMA50|15,EMA100|15,SMA100|15,EMA200|15,SMA200|15,Rec.Ichimoku|15,Ichimoku.BLine|15,Rec.VWMA|15,VWMA|15,Rec.HullMA9|15,HullMA9|15,Pivot.M.Classic.R3|15,Pivot.M.Classic.R2|15,Pivot.M.Classic.R1|15,Pivot.M.Classic.Middle|15,Pivot.M.Classic.S1|15,Pivot.M.Classic.S2|15,Pivot.M.Classic.S3|15,Pivot.M.Fibonacci.R3|15,Pivot.M.Fibonacci.R2|15,Pivot.M.Fibonacci.R1|15,Pivot.M.Fibonacci.Middle|15,Pivot.M.Fibonacci.S1|15,Pivot.M.Fibonacci.S2|15,Pivot.M.Fibonacci.S3|15,Pivot.M.Camarilla.R3|15,Pivot.M.Camarilla.R2|15,Pivot.M.Camarilla.R1|15,Pivot.M.Camarilla.Middle|15,Pivot.M.Camarilla.S1|15,Pivot.M.Camarilla.S2|15,Pivot.M.Camarilla.S3|15,Pivot.M.Woodie.R3|15,Pivot.M.Woodie.R2|15,Pivot.M.Woodie.R1|15,Pivot.M.Woodie.Middle|15,Pivot.M.Woodie.S1|15,Pivot.M.Woodie.S2|15,Pivot.M.Woodie.S3|15,Pivot.M.Demark.R1|15,Pivot.M.Demark.Middle|15,Pivot.M.Demark.S1|15'
            ],
            __(self::ONE_HOUR) => [
                'fields' => 'Recommend.Other|60,Recommend.All|60,Recommend.MA|60,RSI|60,RSI[1]|60,Stoch.K|60,Stoch.D|60,Stoch.K[1]|60,Stoch.D[1]|60,CCI20|60,CCI20[1]|60,ADX|60,ADX+DI|60,ADX-DI|60,ADX+DI[1]|60,ADX-DI[1]|60,AO|60,AO[1]|60,AO[2]|60,Mom|60,Mom[1]|60,MACD.macd|60,MACD.signal|60,Rec.Stoch.RSI|60,Stoch.RSI.K|60,Rec.WR|60,W.R|60,Rec.BBPower|60,BBPower|60,Rec.UO|60,UO|60,EMA10|60,close|60,SMA10|60,EMA20|60,SMA20|60,EMA30|60,SMA30|60,EMA50|60,SMA50|60,EMA100|60,SMA100|60,EMA200|60,SMA200|60,Rec.Ichimoku|60,Ichimoku.BLine|60,Rec.VWMA|60,VWMA|60,Rec.HullMA9|60,HullMA9|60,Pivot.M.Classic.R3|60,Pivot.M.Classic.R2|60,Pivot.M.Classic.R1|60,Pivot.M.Classic.Middle|60,Pivot.M.Classic.S1|60,Pivot.M.Classic.S2|60,Pivot.M.Classic.S3|60,Pivot.M.Fibonacci.R3|60,Pivot.M.Fibonacci.R2|60,Pivot.M.Fibonacci.R1|60,Pivot.M.Fibonacci.Middle|60,Pivot.M.Fibonacci.S1|60,Pivot.M.Fibonacci.S2|60,Pivot.M.Fibonacci.S3|60,Pivot.M.Camarilla.R3|60,Pivot.M.Camarilla.R2|60,Pivot.M.Camarilla.R1|60,Pivot.M.Camarilla.Middle|60,Pivot.M.Camarilla.S1|60,Pivot.M.Camarilla.S2|60,Pivot.M.Camarilla.S3|60,Pivot.M.Woodie.R3|60,Pivot.M.Woodie.R2|60,Pivot.M.Woodie.R1|60,Pivot.M.Woodie.Middle|60,Pivot.M.Woodie.S1|60,Pivot.M.Woodie.S2|60,Pivot.M.Woodie.S3|60,Pivot.M.Demark.R1|60,Pivot.M.Demark.Middle|60,Pivot.M.Demark.S1|60'
            ],
            __(self::FOUR_HOURS) => [
                'fields' => 'Recommend.Other|240,Recommend.All|240,Recommend.MA|240,RSI|240,RSI[1]|240,Stoch.K|240,Stoch.D|240,Stoch.K[1]|240,Stoch.D[1]|240,CCI20|240,CCI20[1]|240,ADX|240,ADX+DI|240,ADX-DI|240,ADX+DI[1]|240,ADX-DI[1]|240,AO|240,AO[1]|240,AO[2]|240,Mom|240,Mom[1]|240,MACD.macd|240,MACD.signal|240,Rec.Stoch.RSI|240,Stoch.RSI.K|240,Rec.WR|240,W.R|240,Rec.BBPower|240,BBPower|240,Rec.UO|240,UO|240,EMA10|240,close|240,SMA10|240,EMA20|240,SMA20|240,EMA30|240,SMA30|240,EMA50|240,SMA50|240,EMA100|240,SMA100|240,EMA200|240,SMA200|240,Rec.Ichimoku|240,Ichimoku.BLine|240,Rec.VWMA|240,VWMA|240,Rec.HullMA9|240,HullMA9|240,Pivot.M.Classic.R3|240,Pivot.M.Classic.R2|240,Pivot.M.Classic.R1|240,Pivot.M.Classic.Middle|240,Pivot.M.Classic.S1|240,Pivot.M.Classic.S2|240,Pivot.M.Classic.S3|240,Pivot.M.Fibonacci.R3|240,Pivot.M.Fibonacci.R2|240,Pivot.M.Fibonacci.R1|240,Pivot.M.Fibonacci.Middle|240,Pivot.M.Fibonacci.S1|240,Pivot.M.Fibonacci.S2|240,Pivot.M.Fibonacci.S3|240,Pivot.M.Camarilla.R3|240,Pivot.M.Camarilla.R2|240,Pivot.M.Camarilla.R1|240,Pivot.M.Camarilla.Middle|240,Pivot.M.Camarilla.S1|240,Pivot.M.Camarilla.S2|240,Pivot.M.Camarilla.S3|240,Pivot.M.Woodie.R3|240,Pivot.M.Woodie.R2|240,Pivot.M.Woodie.R1|240,Pivot.M.Woodie.Middle|240,Pivot.M.Woodie.S1|240,Pivot.M.Woodie.S2|240,Pivot.M.Woodie.S3|240,Pivot.M.Demark.R1|240,Pivot.M.Demark.Middle|240,Pivot.M.Demark.S1|240'
            ],
            __(self::ONE_DAY) => [
                'fields' => 'Recommend.Other,Recommend.All,Recommend.MA,RSI,RSI[1],Stoch.K,Stoch.D,Stoch.K[1],Stoch.D[1],CCI20,CCI20[1],ADX,ADX+DI,ADX-DI,ADX+DI[1],ADX-DI[1],AO,AO[1],AO[2],Mom,Mom[1],MACD.macd,MACD.signal,Rec.Stoch.RSI,Stoch.RSI.K,Rec.WR,W.R,Rec.BBPower,BBPower,Rec.UO,UO,EMA10,close,SMA10,EMA20,SMA20,EMA30,SMA30,EMA50,SMA50,EMA100,SMA100,EMA200,SMA200,Rec.Ichimoku,Ichimoku.BLine,Rec.VWMA,VWMA,Rec.HullMA9,HullMA9,Pivot.M.Classic.R3,Pivot.M.Classic.R2,Pivot.M.Classic.R1,Pivot.M.Classic.Middle,Pivot.M.Classic.S1,Pivot.M.Classic.S2,Pivot.M.Classic.S3,Pivot.M.Fibonacci.R3,Pivot.M.Fibonacci.R2,Pivot.M.Fibonacci.R1,Pivot.M.Fibonacci.Middle,Pivot.M.Fibonacci.S1,Pivot.M.Fibonacci.S2,Pivot.M.Fibonacci.S3,Pivot.M.Camarilla.R3,Pivot.M.Camarilla.R2,Pivot.M.Camarilla.R1,Pivot.M.Camarilla.Middle,Pivot.M.Camarilla.S1,Pivot.M.Camarilla.S2,Pivot.M.Camarilla.S3,Pivot.M.Woodie.R3,Pivot.M.Woodie.R2,Pivot.M.Woodie.R1,Pivot.M.Woodie.Middle,Pivot.M.Woodie.S1,Pivot.M.Woodie.S2,Pivot.M.Woodie.S3,Pivot.M.Demark.R1,Pivot.M.Demark.Middle,Pivot.M.Demark.S1'
            ],
            __(self::ONE_WEEK) => [
                'fields' => 'Recommend.Other|1W,Recommend.All|1W,Recommend.MA|1W,RSI|1W,RSI[1]|1W,Stoch.K|1W,Stoch.D|1W,Stoch.K[1]|1W,Stoch.D[1]|1W,CCI20|1W,CCI20[1]|1W,ADX|1W,ADX+DI|1W,ADX-DI|1W,ADX+DI[1]|1W,ADX-DI[1]|1W,AO|1W,AO[1]|1W,AO[2]|1W,Mom|1W,Mom[1]|1W,MACD.macd|1W,MACD.signal|1W,Rec.Stoch.RSI|1W,Stoch.RSI.K|1W,Rec.WR|1W,W.R|1W,Rec.BBPower|1W,BBPower|1W,Rec.UO|1W,UO|1W,EMA10|1W,close|1W,SMA10|1W,EMA20|1W,SMA20|1W,EMA30|1W,SMA30|1W,EMA50|1W,SMA50|1W,EMA100|1W,SMA100|1W,EMA200|1W,SMA200|1W,Rec.Ichimoku|1W,Ichimoku.BLine|1W,Rec.VWMA|1W,VWMA|1W,Rec.HullMA9|1W,HullMA9|1W,Pivot.M.Classic.R3|1W,Pivot.M.Classic.R2|1W,Pivot.M.Classic.R1|1W,Pivot.M.Classic.Middle|1W,Pivot.M.Classic.S1|1W,Pivot.M.Classic.S2|1W,Pivot.M.Classic.S3|1W,Pivot.M.Fibonacci.R3|1W,Pivot.M.Fibonacci.R2|1W,Pivot.M.Fibonacci.R1|1W,Pivot.M.Fibonacci.Middle|1W,Pivot.M.Fibonacci.S1|1W,Pivot.M.Fibonacci.S2|1W,Pivot.M.Fibonacci.S3|1W,Pivot.M.Camarilla.R3|1W,Pivot.M.Camarilla.R2|1W,Pivot.M.Camarilla.R1|1W,Pivot.M.Camarilla.Middle|1W,Pivot.M.Camarilla.S1|1W,Pivot.M.Camarilla.S2|1W,Pivot.M.Camarilla.S3|1W,Pivot.M.Woodie.R3|1W,Pivot.M.Woodie.R2|1W,Pivot.M.Woodie.R1|1W,Pivot.M.Woodie.Middle|1W,Pivot.M.Woodie.S1|1W,Pivot.M.Woodie.S2|1W,Pivot.M.Woodie.S3|1W,Pivot.M.Demark.R1|1W,Pivot.M.Demark.Middle|1W,Pivot.M.Demark.S1|1W'
            ],
            __(self::ONE_MONTH) => [
                'fields' => 'Recommend.Other|1M,Recommend.All|1M,Recommend.MA|1M,RSI|1M,RSI[1]|1M,Stoch.K|1M,Stoch.D|1M,Stoch.K[1]|1M,Stoch.D[1]|1M,CCI20|1M,CCI20[1]|1M,ADX|1M,ADX+DI|1M,ADX-DI|1M,ADX+DI[1]|1M,ADX-DI[1]|1M,AO|1M,AO[1]|1M,AO[2]|1M,Mom|1M,Mom[1]|1M,MACD.macd|1M,MACD.signal|1M,Rec.Stoch.RSI|1M,Stoch.RSI.K|1M,Rec.WR|1M,W.R|1M,Rec.BBPower|1M,BBPower|1M,Rec.UO|1M,UO|1M,EMA10|1M,close|1M,SMA10|1M,EMA20|1M,SMA20|1M,EMA30|1M,SMA30|1M,EMA50|1M,SMA50|1M,EMA100|1M,SMA100|1M,EMA200|1M,SMA200|1M,Rec.Ichimoku|1M,Ichimoku.BLine|1M,Rec.VWMA|1M,VWMA|1M,Rec.HullMA9|1M,HullMA9|1M,Pivot.M.Classic.R3|1M,Pivot.M.Classic.R2|1M,Pivot.M.Classic.R1|1M,Pivot.M.Classic.Middle|1M,Pivot.M.Classic.S1|1M,Pivot.M.Classic.S2|1M,Pivot.M.Classic.S3|1M,Pivot.M.Fibonacci.R3|1M,Pivot.M.Fibonacci.R2|1M,Pivot.M.Fibonacci.R1|1M,Pivot.M.Fibonacci.Middle|1M,Pivot.M.Fibonacci.S1|1M,Pivot.M.Fibonacci.S2|1M,Pivot.M.Fibonacci.S3|1M,Pivot.M.Camarilla.R3|1M,Pivot.M.Camarilla.R2|1M,Pivot.M.Camarilla.R1|1M,Pivot.M.Camarilla.Middle|1M,Pivot.M.Camarilla.S1|1M,Pivot.M.Camarilla.S2|1M,Pivot.M.Camarilla.S3|1M,Pivot.M.Woodie.R3|1M,Pivot.M.Woodie.R2|1M,Pivot.M.Woodie.R1|1M,Pivot.M.Woodie.Middle|1M,Pivot.M.Woodie.S1|1M,Pivot.M.Woodie.S2|1M,Pivot.M.Woodie.S3|1M,Pivot.M.Demark.R1|1M,Pivot.M.Demark.Middle|1M,Pivot.M.Demark.S1|1M'
            ]
        ];

        $params = $stamps[$stamp] + [
                'symbol' => $currency_code,
                'no_404' => 'true',
                'label-product' => 'popup-technicals'
        ];

        $response = (new Client())->request('GET', 'https://scanner.tradingview.com/symbol', [
            'query' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private static function get_keys_value($keys, $data){
        $modified_keys = [];
        foreach ($keys as $key){
            foreach ($data as $data_key => $value){
                $data_key = explode('|', $data_key)[0];
                if ($data_key == $key){
                    $modified_keys[$key] = $value;
                    break;
                }
            }
        }
        return $modified_keys;
    }

    private static function get_close_price($data){
        foreach ($data as $data_key => $value){
            $data_key = explode('|', $data_key)[0];
            if ($data_key == 'close'){
                return $value;
            }
        }
    }

    public static function get_corresponding_angle($signals, $signal=null){
        $total = array_sum($signals);

        $signals['STRONG_BUY'] = $signals['STRONG_BUY'] ?? 0;
        $signals['STRONG_SELL'] = $signals['STRONG_SELL'] ?? 0;

        if ($signal){
            if ($signal == "BUY" && $signals[$signal] / $total > 0.3){
                $signal = "STRONG_BUY";
            }elseif($signal == "SELL" && $signals[$signal] / $total > 0.3){
                $signal = "STRONG_SELL";
            }
        }

        return [
            'STRONG_SELL' => -50,
            'SELL' => -40 + 20 * $signals[$signal] / $total,
            'NEUTRAL' => -20 + 38 * $signals[$signal] / $total,
            'BUY' => 20 + 18 * $signals[$signal] / $total,
            'STRONG_BUY' => 50,
        ][$signal];
    }

    public static function general_signal($data){
        $signals = [
            'STRONG_BUY' => 0,
            'BUY' => 0,
            'NEUTRAL' => 0,
            'SELL' => 0,
            'STRONG_SELL' => 0,
        ];

        $data = self::get_keys_value([
            'Recommend.All',
            'Recommend.MA',
            'Recommend.Other'
        ], $data);

        if ($data['Recommend.All'] >= -1 && $data['Recommend.All'] < -0.5) {
            $signals['STRONG_SELL'] += 1;
        }elseif ($data['Recommend.All'] >= -0.5 && $data['Recommend.All'] < -0.1) {
            $signals['SELL'] += 1;
        }elseif ($data['Recommend.All'] >= -0.1 && $data['Recommend.All'] < 0.1) {
            $signals['NEUTRAL'] += 1;
        }elseif ($data['Recommend.All'] > 0.1 && $data['Recommend.All'] <= 0.5) {
            $signals['BUY'] += 1;
        }elseif ($data['Recommend.All'] > 0.5 && $data['Recommend.All'] < 1) {
            $signals['STRONG_BUY'] += 1;
        }else{
            $signals['NEUTRAL'] += 1;
        }

        if ($data['Recommend.MA'] >= -1 && $data['Recommend.MA'] < -0.5) {
            $signals['STRONG_SELL'] += 1;
        }elseif ($data['Recommend.MA'] >= -0.5 && $data['Recommend.MA'] < -0.1) {
            $signals['SELL'] += 1;
        }elseif ($data['Recommend.MA'] >= -0.1 && $data['Recommend.MA'] < 0.1) {
            $signals['NEUTRAL'] += 1;
        }elseif ($data['Recommend.MA'] > 0.1 && $data['Recommend.MA'] <= 0.5) {
            $signals['BUY'] += 1;
        }elseif ($data['Recommend.MA'] > 0.5 && $data['Recommend.MA'] < 1) {
            $signals['STRONG_BUY'] += 1;
        }else{
            $signals['NEUTRAL'] += 1;
        }

        return [
            'signal' => array_keys($signals, max($signals))[0],
            'signals' => $signals
        ];
    }

    public static function moving_averages(array $data){
        $pairs = [];

        $signals = [
            'BUY' => 0,
            'NEUTRAL' => 0,
            'SELL' => 0,
        ];

        $close_price = self::get_close_price($data);
        $data = self::get_keys_value([
            'EMA10',
            'SMA10',
            'EMA20',
            'SMA20',
            'EMA30',
            'SMA30',
            'EMA50',
            'SMA50',
            'EMA100',
            'SMA100',
            'EMA200',
            'SMA200',
            'Ichimoku.BLine',
            'VWMA',
            'HullMA9'
        ], $data);

        foreach ($data as $value)
            $pairs[] = [$value, $close_price];

        foreach ($pairs as $pair) {
            $mao = $pair[1] - $pair[0];
            if ($mao > 0)
                $signals['BUY'] += 1;
            elseif ($mao < 0)
                $signals['SELL'] += 1;
            else
                $signals['NEUTRAL'] += 1;
        }

        return [
            'signal' => array_keys($signals, max($signals))[0],
            'signals' => $signals,
        ];
    }

    public static function oscillators_signal($data) {
        $signals = [
            'BUY' => 0,
            'NEUTRAL' => 0,
            'SELL' => 0,
        ];

        $data = self::get_keys_value([
            'RSI',
            'RSI[1]',
            'Stoch.D',
            'Stoch.D[1]',
            'Stoch.K',
            'Stoch.K[1]',
            'Stoch.RSI.K',
            'CCI20',
            'CCI20[1]',
            'ADX',
            'ADX+DI',
            'ADX+DI[1]',
            'ADX-DI',
            'ADX-DI[1]',
            'AO',
            'AO[1]',
            'AO[2]',
            'MACD.macd',
            'MACD.signal',
            'W.R',
            'BBPower',
            'Rec.UO',
            'UO'
        ], $data);

        if (isset($data['RSI'], $data['RSI[1]'])) {
            if ($data['RSI'] < 30 && $data['RSI[1]'] < $data['RSI'])
                $signals['BUY'] += 1;
            elseif ($data['RSI'] > 70 && $data['RSI[1]'] > $data['RSI']) {
                $signals['SELL'] += 1;
            }else {
                $signals['NEUTRAL'] += 1;
            }
        }

        if (isset($data['Stoch.K'], $data['Stoch.D'], $data['Stoch.K[1]'], $data['Stoch.D[1]'])) {
            if ($data['Stoch.K'] < 20 && $data['Stoch.D'] < 20 && $data['Stoch.K'] > $data['Stoch.D'] && $data['Stoch.K[1]'] < $data['Stoch.D[1]']) {
                $signals['BUY'] += 1;
            }elseif ($data['Stoch.K'] > 80 && $data['Stoch.D'] > 80 && $data['Stoch.K'] < $data['Stoch.D'] && $data['Stoch.K[1]'] > $data['Stoch.D[1]']) {
                $signals['SELL'] += 1;
            }else {
                $signals['NEUTRAL'] += 1;
            }
        }

        if (isset($data['CCI20'], $data['CCI20[1]'])) {
            if ($data['CCI20'] < -100 && $data['CCI20'] > $data['CCI20[1]']) {
                $signals['BUY'] += 1;
            }elseif($data['CCI20'] > 100 && $data['CCI20'] < $data['CCI20[1]']){
                $signals['SELL'] += 1;
            }else{
                $signals['NEUTRAL'] += 1;
            }
        }

        if (isset($data['ADX'], $data['ADX+DI'], $data['ADX-DI'], $data['ADX+DI[1]'], $data['ADX-DI[1]'])) {
            if ($data['ADX'] > 20 && $data['ADX+DI[1]'] < $data['ADX-DI[1]'] && $data['ADX+DI'] > $data['ADX-DI']) {
                $signals['BUY'] += 1;
            }elseif ($data['ADX'] > 20 && $data['ADX+DI[1]'] > $data['ADX-DI[1]'] && $data['ADX+DI'] < $data['ADX-DI']) {
                $signals['SELL'] += 1;
            }else{
                $signals['NEUTRAL'] += 1;
            }
        }

        if (isset($data['AO'], $data['AO[1]'], $data['AO[2]'])){
            if ($data['AO'] > 0 && $data['AO[1]'] < 0 || $data['AO'] > 0 && $data['AO[1]'] > 0 && $data['AO'] > $data['AO[1]'] && $data['AO[2]'] > $data['AO[1]']){
                $signals['BUY'] += 1;
            }elseif ($data['AO'] < 0 && $data['AO[1]'] > 0 || $data['AO'] < 0 && $data['AO[1]'] < 0 && $data['AO'] < $data['AO[1]'] && $data['AO[2]'] < $data['AO[1]']){
                $signals['SELL'] += 1;
            }else{
                $signals['NEUTRAL'] += 1;
            }
        }

        if (isset($data['Mom'], $data['Mom[1]'])){
            if ($data['Mom'] > $data['Mom[1]']){
                $signals['BUY'] += 1;
            }elseif ($data['Mom'] < $data['Mom[1]']){
                $signals['SELL'] += 1;
            }else{
                $signals['NEUTRAL'] += 1;
            }
        }

        if (isset($data['MACD.macd'], $data['MACD.signal'])){
            if ($data['MACD.macd'] > $data['MACD.signal']){
                $signals['BUY'] += 1;
            }elseif($data['MACD.signal'] < $data['MACD.signal']){
                $signals['SELL'] += 1;
            }else{
                $signals['NEUTRAL'] += 1;
            }
        }

        return [
            'signal' => array_keys($signals, max($signals))[0],
            'signals' => $signals,
        ];
    }
}