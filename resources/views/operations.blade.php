<div class="operations">
    @if(count($operations) > 0)
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>Date</th>
                <th>Operation</th>
                <th>&#8372;, hrn</th>
                <th>$, doll</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($operations as $operation)
                <tr>
                    <td>{{$operation->created_at}}</td>
                    <td>{{$operation->name}}</td>
                    <td>{{$operation->val_grn}}</td>
                    <td>{{$operation->val_dol}}</td>
                    <td><button  class="btn btn-warning btn-xs id{{$operation->id}} edit">Edit</button></td>
                    <td><button  class="btn btn-danger btn-xs id{{$operation->id}} delete">Delete</button></td>
                </tr>
            @endforeach

            <tr class="warning">
                <td></td>
                <td>Summary</td>
                <td id="summary_grn">{{$summary_grn}}</td>
                <td id="summary_dol">{{$summary_dol}}</td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>

    @else

        <div class="well">
            <b>No operation found!</b>
        </div>

    @endif
</div>