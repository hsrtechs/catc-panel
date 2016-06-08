@extends('gentelella.layout.main')
@section('main')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Default Example <small>Users</small></h2>
                <div class="clearfix"></div>
            </div>
            <p class="text-muted font-13 m-b-30">
                DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
            </p>
            @if(count($tickets))
            <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
                <thead>
                <tr role="row">
                    <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 30px;">S.No</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 100px;">Title</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 87px;">User</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 118px;">Status</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Created</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 59px;">Last Updated</th>
                </tr>
                </thead>
                <tbody>
                <?php $x = 1; ?>
                @foreach($tickets as $ticket)
                    <tr role="row" class="{{ ($x % 2) ? 'even' : 'odd' }}">
                        <td><a href="{{ action('TicketsController@view',['id' => $ticket->id]) }}">#{{ $ticket->id }}</a></td>
                        <td class="sorting_1"><a href="{{ action('TicketsController@view',['id' => $ticket->id]) }}">{{ $ticket->title }}</a></td>
                        <td><a href="{{ action('UserController@Profile',['user' => $ticket->User->username]) }}">{{ $ticket->User->name }}</a></td>
                        <td class="{{ $ticket->getStatusClass() }}">{{ $ticket->status }}</td>
                        <td>{{ $ticket->created_at->diffForHumans() }}</td>
                        <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                    </tr>
                    <?php $x++; ?>
                @endforeach
                </tbody>
            </table>
            @else
                <h3 class="green">No Tickets Found</h3>
            @endif
        </div>
    </div>
@endsection
@section('css')
        <!-- Datatables -->
    <link href="/css/datatables/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/css/datatables/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/css/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="/css/datatables/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="/css/datatables/scroller.bootstrap.min.css" rel="stylesheet">

@endsection

@section('js')
        <!-- Datatables -->
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/js/datatables/dataTables.buttons.min.js"></script>
    <script src="/js/datatables/buttons.bootstrap.min.js"></script>
    <script src="/js/datatables/buttons.flash.min.js"></script>
    <script src="/js/datatables/buttons.html5.min.js"></script>
    <script src="/js/datatables/buttons.print.min.js"></script>
    <script src="/js/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="/js/datatables/dataTables.keyTable.min.js"></script>
    <script src="/js/datatables/dataTables.responsive.min.js"></script>
    <script src="/js/datatables/responsive.bootstrap.js"></script>
    <script src="/js/datatables/dataTables.scroller.min.js"></script>
    <script src="/js/jszip.min.js"></script>

    <script>
        $('#datatable').dataTable();
    </script>

@endsection 