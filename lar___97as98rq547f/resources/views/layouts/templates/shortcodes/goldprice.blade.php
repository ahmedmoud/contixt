
<table class="goldtable">
    <thead>
        <tr>
            <th>العيار</th>
            <th>السعر(ج.م)</th>
            <th>السعر($)</th>
            <th>آخر تحديث</th>
        </tr>
    </thead>
    <tbody>

    @foreach ($data as $single )
        <tr>
            <td>{{ strpos($single->type_ar, 'عيار') !== false ? 'سعر جرام الذهب' : 'سعر' }} {{ $single->type_ar }}</td>
            <td>{{ $single->price }} ج.م</td>
            <td>{{ $single->usd_price }} $</td>
@php

$date = new DateTime( $single->last_update );
$now = new DateTime();

$hours = $date->diff($now)->format("%h");
$minutes = $date->diff($now)->format("%i");
$days = $date->diff($now)->format("%d");

$diff = $days > 0 ? $days.' يوم ' : ( $hours > 0 ?  $hours.' ساعة' : $minutes.' دقيقة' );


@endphp
            <td>منذ {{ $diff }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
