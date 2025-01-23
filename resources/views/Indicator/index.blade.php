@extends('layouts.main')

@section('title', __('site.Indicator'))

@section('id', 'Indicator')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/AboutUs.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/indicator.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/authentication.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/Recommendations.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/personal-consultation.css')}}"/>
@endpush

@section('content')
    <div class="indicator">
        <div class="container">
            <div class="indicator-links">
                @foreach($stamps as $stamp)
                    <a href="?stamp={{$stamp}}&currency={{$currency->code}}" class="@if($stamp == $selected_stamp) active @endif">{{$stamp}}</a>
                @endforeach
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 d-flex align-items-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">@lang('site.SYMBOL')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($currencies as $currency)
                                <tr>
                                    <th scope="row">
                                        <a href="?stamp={{$stamp}}&currency={{$currency->code}}" class="text-decoration-none text-dark">
                                            <picture>
                                                <x-curator-glider
                                                        :media="$currency->image_id"
                                                        class="mw-100"
                                                />
                                            </picture>
                                            {{$currency->title}}
                                        </a>
                                    </th>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-10 indicator-chart">
                    <h3>@lang('site.SUMMARY')</h3>
                    <div id="gauge-container" class="gauge-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="indicator indicator-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 indicator-chart mb-4">
                    <h3>@lang('site.OSCILLATORS')</h3>
                    <div
                            id="gauge-container-two"
                            class="gauge-container gauge-container-two"
                    ></div>
                </div>
                <div class="col-lg-6 indicator-chart mb-4">
                    <h3>@lang('site.MOVING_AVERAGES')</h3>
                    <div
                            id="gauge-container-three"
                            class="gauge-container gauge-container-three"
                    ></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        // Function to draw the gauge
        function drawGauge() {
            // Clear existing SVG if any
            d3.select("#gauge-container").selectAll("*").remove();

            // Dynamically calculate dimensions based on screen size
            const width = Math.min(window.innerWidth * 0.9, 800); // Max width 600px
            const height = width; // Keep it square
            const radius = width / 4; // Set radius as 1/4th of the width

            // Create SVG container inside the parent div
            const svg = d3
                .select("#gauge-container")
                .append("svg")
                .attr("width", width)
                .attr("height", height);

            // Create a group for the gauge
            const gaugeGroup = svg
                .append("g")
                .attr("transform", `translate(${width / 2}, ${height / 2})`);

            // Define the scale (0 to 100)
            const scale = d3
                .scaleLinear()
                .domain([0, 100])
                .range([-Math.PI / 2, Math.PI / 3]);

            // Define arcs for different zones
            const arc = d3
                .arc()
                .innerRadius(radius - 15)
                .outerRadius(radius);

            const zones = [
                { start: -60, end: -40, color: "transparent", label: "@lang('site.STRONG_SELL')" },
                { start: -40, end: -20, color: "transparent", label: "@lang('site.SELL')" },
                { start: -20, end: 0, color: "transparent", label: "@lang('site.NEUTRAL')" },
                { start: 0, end: 18, color: "#FF5656", label: "@lang('site.NEUTRAL')" },
                { start: 20, end: 38, color: "#FF8888", label: "@lang('site.BUY')" },
                { start: 40, end: 58, color: "#FEE114", label: "@lang('site.STRONG_BUY')" },
                { start: 60, end: 78, color: "#FEE114" },
                { start: 80, end: 98, color: "#84BD32" },
                { start: 100, end: 120, color: "#30AD43" },
            ];

            zones.forEach((zone) => {
                gaugeGroup
                    .append("path")
                    .datum({ startAngle: scale(zone.start), endAngle: scale(zone.end) })
                    .attr("d", arc)
                    .attr("fill", zone.color);

                // Add labels for each zone
                const labelAngle = (scale(zone.start) + scale(zone.end)) / 2;
                const x = Math.cos(labelAngle) * (radius - -50);
                const y = Math.sin(labelAngle) * (radius - -30);

                gaugeGroup
                    .append("text")
                    .attr("x", x)
                    .attr("y", y + 4)
                    .attr("text-anchor", "middle")
                    .attr("font-size", "20px")
                    .attr("fill", "#000")
                    .text(zone.label);
            });

            // Add needle
            const value = {{$general_signal}}; // Set value here
            const needleAngle = scale(value);

            gaugeGroup
                .append("line")
                .attr("x1", 0)
                .attr("y1", 0)
                .attr("x2", Math.cos(needleAngle) * (radius - 20))
                .attr("y2", Math.sin(needleAngle) * (radius - 20))
                .attr("stroke", "#000")
                .attr("stroke-width", 3);

            // تحديد التسمية للمنطقة بناءً على الزاوية
            let zoneLabel = "";
            zones.forEach((zone) => {
                if (
                    needleAngle >= scale(zone.start) &&
                    needleAngle <= scale(zone.end)
                ) {
                    zoneLabel = zone.label;
                }
            });

            // Add value label with the zone label
            svg
                .append("text")
                .attr("x", width / 2)
                .attr("y", height / 2 + radius / 2)
                .attr("text-anchor", "middle")
                .attr("font-size", "16px")
                .attr("fill", "#000")
                .text(` ${zoneLabel}`);
        }

        // Initial render
        drawGauge();

        // Redraw on window resize
        window.addEventListener("resize", drawGauge);
    </script>
    <script>
        // Function to draw the gauge
        function drawGauge() {
            // Clear existing SVG if any
            d3.select("#gauge-container-two").selectAll("*").remove();

            // Dynamically calculate dimensions based on screen size
            const width = Math.min(window.innerWidth * 0.9, 600); // Max width 600px
            const height = width; // Keep it square
            const radius = width / 4; // Set radius as 1/4th of the width

            // Create SVG container inside the parent div
            const svg = d3
                .select("#gauge-container-two")
                .append("svg")
                .attr("width", width)
                .attr("height", height);

            // Create a group for the gauge
            const gaugeGroup = svg
                .append("g")
                .attr("transform", `translate(${width / 2}, ${height / 2})`);

            // Define the scale (0 to 100)
            const scale = d3
                .scaleLinear()
                .domain([0, 100])
                .range([-Math.PI / 2, Math.PI / 3]);

            // Define arcs for different zones
            const arc = d3
                .arc()
                .innerRadius(radius - 15)
                .outerRadius(radius);

            const zones = [
                { start: -60, end: -40, color: "transparent", label: "@lang('site.STRONG_SELL')" },
                { start: -40, end: -20, color: "transparent", label: "@lang('site.SELL')" },
                { start: -20, end: 0, color: "transparent", label: "@lang('site.NEUTRAL')" },
                { start: 0, end: 18, color: "#FF5656", label: "@lang('site.NEUTRAL')" },
                { start: 20, end: 38, color: "#FF8888", label: "@lang('site.BUY')" },
                { start: 40, end: 58, color: "#FEE114", label: "@lang('site.STRONG_BUY')" },
                { start: 60, end: 78, color: "#FEE114" },
                { start: 80, end: 98, color: "#84BD32" },
                { start: 100, end: 120, color: "#30AD43" },
            ];

            zones.forEach((zone) => {
                gaugeGroup
                    .append("path")
                    .datum({ startAngle: scale(zone.start), endAngle: scale(zone.end) })
                    .attr("d", arc)
                    .attr("fill", zone.color);

                // Add labels for each zone
                const labelAngle = (scale(zone.start) + scale(zone.end)) / 2;
                const x = Math.cos(labelAngle) * (radius - -50);
                const y = Math.sin(labelAngle) * (radius - -30);

                gaugeGroup
                    .append("text")
                    .attr("x", x)
                    .attr("y", y + 4)
                    .attr("text-anchor", "middle")
                    .attr("font-size", "20px")
                    .attr("fill", "#000")
                    .text(zone.label);
            });

            // Add needle
            const value = {{$oscillators_signal}}; // Set value here
            const needleAngle = scale(value);

            gaugeGroup
                .append("line")
                .attr("x1", 0)
                .attr("y1", 0)
                .attr("x2", Math.cos(needleAngle) * (radius - 20))
                .attr("y2", Math.sin(needleAngle) * (radius - 20))
                .attr("stroke", "#000")
                .attr("stroke-width", 3);

            // تحديد التسمية للمنطقة بناءً على الزاوية
            let zoneLabel = "";
            zones.forEach((zone) => {
                if (
                    needleAngle >= scale(zone.start) &&
                    needleAngle <= scale(zone.end)
                ) {
                    zoneLabel = zone.label;
                }
            });

            // Add value label with the zone label
            svg
                .append("text")
                .attr("x", width / 2)
                .attr("y", height / 2 + radius / 2)
                .attr("text-anchor", "middle")
                .attr("font-size", "16px")
                .attr("fill", "#000")
                .text(` ${zoneLabel}`);
        }

        // Initial render
        drawGauge();

        // Redraw on window resize
        window.addEventListener("resize", drawGauge);
    </script>
    <script>
        // Function to draw the gauge
        function drawGauge() {
            // Clear existing SVG if any
            d3.select("#gauge-container-three").selectAll("*").remove();

            // Dynamically calculate dimensions based on screen size
            const width = Math.min(window.innerWidth * 0.9, 600); // Max width 600px
            const height = width; // Keep it square
            const radius = width / 4; // Set radius as 1/4th of the width

            // Create SVG container inside the parent div
            const svg = d3
                .select("#gauge-container-three")
                .append("svg")
                .attr("width", width)
                .attr("height", height);

            // Create a group for the gauge
            const gaugeGroup = svg
                .append("g")
                .attr("transform", `translate(${width / 2}, ${height / 2})`);

            // Define the scale (0 to 100)
            const scale = d3
                .scaleLinear()
                .domain([0, 100])
                .range([-Math.PI / 2, Math.PI / 3]);

            // Define arcs for different zones
            const arc = d3
                .arc()
                .innerRadius(radius - 15)
                .outerRadius(radius);

            const zones = [
                { start: -60, end: -40, color: "transparent", label: "@lang('site.STRONG_SELL')" },
                { start: -40, end: -20, color: "transparent", label: "@lang('site.SELL')" },
                { start: -20, end: 0, color: "transparent", label: "@lang('site.NEUTRAL')" },
                { start: 0, end: 18, color: "#FF5656", label: "@lang('site.NEUTRAL')" },
                { start: 20, end: 38, color: "#FF8888", label: "@lang('site.BUY')" },
                { start: 40, end: 58, color: "#FEE114", label: "@lang('site.STRONG_BUY')" },
                { start: 60, end: 78, color: "#FEE114" },
                { start: 80, end: 98, color: "#84BD32" },
                { start: 100, end: 120, color: "#30AD43" },
            ];

            zones.forEach((zone) => {
                gaugeGroup
                    .append("path")
                    .datum({ startAngle: scale(zone.start), endAngle: scale(zone.end) })
                    .attr("d", arc)
                    .attr("fill", zone.color);

                // Add labels for each zone
                const labelAngle = (scale(zone.start) + scale(zone.end)) / 2;
                const x = Math.cos(labelAngle) * (radius - -50);
                const y = Math.sin(labelAngle) * (radius - -30);

                gaugeGroup
                    .append("text")
                    .attr("x", x)
                    .attr("y", y + 4)
                    .attr("text-anchor", "middle")
                    .attr("font-size", "20px")
                    .attr("fill", "#000")
                    .text(zone.label);
            });

            // Add needle
            const value = {{$moving_averages_signal}}; // Set value here
            const needleAngle = scale(value);

            gaugeGroup
                .append("line")
                .attr("x1", 0)
                .attr("y1", 0)
                .attr("x2", Math.cos(needleAngle) * (radius - 20))
                .attr("y2", Math.sin(needleAngle) * (radius - 20))
                .attr("stroke", "#000")
                .attr("stroke-width", 3);

            let zoneLabel = "";
            zones.forEach((zone) => {
                if (
                    needleAngle >= scale(zone.start) &&
                    needleAngle <= scale(zone.end)
                ) {
                    zoneLabel = zone.label;
                }
            });

            // Add value label with the zone label
            svg
                .append("text")
                .attr("x", width / 2)
                .attr("y", height / 2 + radius / 2)
                .attr("text-anchor", "middle")
                .attr("font-size", "16px")
                .attr("fill", "#000")
                .text(` ${zoneLabel}`);
        }

        // Initial render
        drawGauge();

        // Redraw on window resize
        window.addEventListener("resize", drawGauge);
    </script>
@endpush