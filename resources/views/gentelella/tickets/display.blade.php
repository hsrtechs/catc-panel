@extends('gentelella.layout.main')
@section('main')
        <div class="">

            @include('gentelella.partials.page-tittle',['heading' => 'Ticket #'.$ticket->id])
            <div class="row">

                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2> Ticket #{{ $ticket->id }}<small>{{ $ticket->title }}</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-3 mail_list_column">
                                    <div role="tablist">
                                        <div role="presentation" class="active">
                                            <a href="#ticket-tab" aria-controls="ticket-tab" role="tab" data-toggle="tab">
                                                <div class="mail_list active" >
                                                    <div class="left">
                                                        <i class="fa fa-circle"></i> <i class="fa fa-edit"></i>
                                                    </div>
                                                    <div class="right">
                                                        <h3>{{ $ticket->User->name }} <small>{{ $ticket->created_at->diffForHumans() }}</small></h3>
                                                        <p><strong>{{ $ticket->title }}</strong><br />
                                                        {{ $ticket->desc }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @foreach($ticket->Replies->sortByDesc('updated_at') as $reply)
                                            <div role="presentation">
                                                <a href="#reply-{{ $reply->id }}-base" aria-controls="reply-{{ $reply->id }}-base" role="tab" data-toggle="tab">
                                                    <div class="mail_list active">
                                                        <div class="left">
                                                            <i class="fa fa-circle"></i> <i class="fa fa-edit"></i>
                                                        </div>
                                                        <div class="right">
                                                            <h3>{{ $reply->User->name }} <small>{{ $ticket->created_at->diffForHumans() }}</small></h3>
                                                            <p>
                                                                {{ $reply->reply }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- /MAIL LIST -->
                                <!-- CONTENT MAIL -->
                                <div class="col-sm-9 mail_view">
                                    <div class="inbox-body">
                                        <div class="mail_heading row">
                                            <div class="col-md-8">
                                                <div class="compose-btn">
                                                    <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-reply"></i> Reply</a>
                                                    <button title="" data-placement="top" data-toggle="tooltip" type="button" data-original-title="Print" class="btn  btn-sm tooltips"><i class="fa fa-print"></i> </button>
                                                    <button title="" data-placement="top" data-toggle="tooltip" data-original-title="Trash" class="btn btn-sm tooltips"><i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>

                                            </div>
                                            <div class="col-md-4 text-right">
                                                <p class="date">Ticket Created: {{ $ticket->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <h4>{{ $ticket->title }}</h4>
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="ticket-tab">
                                                <div class="sender-info">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <strong>{{ $ticket->User->name }}</strong>
                                                            <span>({{ $ticket->User->Role->name }})</span> to
                                                            <strong>Staff</strong>
                                                            <a class="sender-dropdown"><i class="fa fa-chevron-down"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="view-mail">
                                                    <p>
                                                        {{ $ticket->desc }}
                                                    </p>
                                                </div>
                                            </div>
                                            @foreach($ticket->Replies as $reply)
                                                <div role="tabpanel" class="tab-pane fade in" id="reply-{{ $reply->id }}-base">
                                                    <div class="sender-info">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <strong>{{ $reply->User->name }}</strong>
                                                                <span>({{ $reply->User->Role->name }})</span> to
                                                                <strong>{{ $ticket->User->name }}</strong>
                                                                <a class="sender-dropdown"><i class="fa fa-chevron-down"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="view-mail">
                                                        <p>
                                                            {{ $reply->reply }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- /CONTENT MAIL -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection