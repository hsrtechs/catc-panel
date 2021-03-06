@extends('gentelella.layout.main')
@section('main')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Build Server <small>Create new Server</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form method="post" action="{{ action('ServerController@changeServerOwnerPost',$id) }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">User:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <select name="user" class="select2_single form-control" tabindex="-1">
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}"{{ ($u->id === $uid) ? ' selected' : '' }}>{{ $u->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    @if(\Session::has('build'))
        <script>
            alert("{{ \Session::get('build') }}");
        </script>
        @endif
        @endsection
        @section('js')
                <!-- Select2 -->
        <script src="/js/select2.full.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".select2_single").select2({
                    allowClear: true
                });
            });
        </script>
@endsection
@section('css')
    <link type="text/css" href="/css/select2.min.css" rel="stylesheet">
@endsection