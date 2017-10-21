@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h5>Accounting table</h5> </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <span>Choose period: </span> &nbsp;
                        <label for="from">From </label> &nbsp; <input id="from" type="date" value="{{$lastmonth}}"/>
                        <label for="to">To </label> &nbsp; <input id="to" type="date" value="{{$today}}"/>
     <!--...................................................Operations.................................................................-->
                   <div id="operations">
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
                        <!--...................................................Operations end.................................................................-->
                            <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" id="open" >
                            Add operation
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal ADD Operation -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add operation</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" action="{{ url('/addOperation') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"
                                       required autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="val_grn" class="col-md-4 control-label">Value(grn)</label>

                            <div class="col-md-6">
                                <input id="val_grn" type="number" class="form-control" name="val_grn"
                                     required autofocus>

                            </div>
                        </div>
                       <p style="color: red" id="alert"></p>

                        <div class="modal-footer">
                            <button id="close" type="button" class="btn btn-default" >Close</button>
                            <button id="saveOperation" type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Operation -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit operation</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" action="{{ url('/addOperation') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name_edit" type="text" class="form-control" name="name_edit"
                                        required autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="val_grn" class="col-md-4 control-label">Value(grn)</label>

                            <div class="col-md-6">
                                <input id="val_grn_edit" type="number" class="form-control" name="val_grn_edit"
                                      required autofocus>

                            </div>
                        </div>
                        <p style="color: red" id="alert_edit"></p>

                        <div class="modal-footer">
                            <button id="close_edit" type="button" class="btn btn-default" >Close</button>
                            <button id="editOperation" type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
