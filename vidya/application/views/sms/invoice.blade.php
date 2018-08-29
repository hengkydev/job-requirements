{{$__CONFIG->name}} pembelian , no {{$transaction->invoice}} , total tagihan {{$transaction->price_text->grand_total}} , Transfer ke rekening : 
@foreach($account as $result)
{{$result->bank}} {{$result->name}} {{$result->number}}
@endforeach


