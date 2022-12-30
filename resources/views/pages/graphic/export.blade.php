<table  class="table table-striped" >
    <thead>
    <tr>
        <th>№</th>
        <th>Ism familiya</th>
        <th>Oy</th>
        <th>To'langan</th>
        <th>Chegirma</th>
        <th>Qarz</th>
    </tr>
    </thead>
    @foreach($graphics as $graphic)
        <tbody>
        <tr>
            <td>{{$loop->index+1}}</td>
            <td >@if(isset($graphic->student)) {{$graphic->student->name}} @else Mavjud emas @endif</td>
            <td>{{date('F', strtotime($graphic->month))}}</td>
            <td>{{$graphic->paid_amount}} so'm</td>
            <td>{{$graphic->discount_amount}} so'm</td>
            <td>{{$graphic->remaining_amount}} so'm</td>
        </tr>
        </tbody>
    @endforeach
</table>
