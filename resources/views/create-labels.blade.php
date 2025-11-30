@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Bulk Label creation
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.labels.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')


    <form method="POST" action="{{ route('settings.labels.create') }}" accept-charset="UTF-8" autocomplete="off" class="form-horizontal" role="form">
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        Bulk Label creation
                    </h2>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        {!! $errors->first('settings', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <div class="col-md-3 text-right">
                                <label for="next">Next Asset Tag</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" disabled name="next" type="text" id="next" value="{{ $nextAssetTag }}">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('start_at') ? 'error' : '' }}">
                            <div class="col-md-3 text-right">
                                <label for="start_at">Start at</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control"  name="start_at" type="text" id="start_at" value="{{ old('start_at', $nextAssetNumber) }}">

                                {!! $errors->first('start_at', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('count') ? 'error' : '' }}">
                            <div class="col-md-3 text-right">
                                <label for="count">Count</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control"  name="count" type="number" id="count" min="1" value="{{ old('count', 1) }}">

                                {!! $errors->first('count', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                    </div>


                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.labels.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-success"{{ (config('app.lock_passwords')===true) ? ' disabled': '' }}><x-icon type="checkmark" /> {{ trans('general.generate') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    </form>

@stop
