
{{Form::hidden('s_id', $detail->uid )}}
{{Form::hidden('m_id', session('e_id'))}}
{{Form::hidden('created_by', session('e_id'))}}
    <div class="form-group">
        {{Form::label('date', 'Enter Date')}}
        {{Form::date('date', \Carbon\Carbon::now())}}
    </div>
    <div class="form-group">
        {{ Form::label('time', 'Enter Time')}}
        {{ Form::time('time', Carbon\Carbon::now()->format('H:i'))}}
    </div>
    <div class="form-group">
        {{Form::label('query', 'Enter Discussion Title')}}
        {{Form::text('query', '',['class' => 'form-control', 'placeholder' => 'Query Title'])}}
    </div>
    <div class="form-group">
        {{Form::label('description', 'Enter Description')}}
        {{Form::textarea('description', '',['class' => 'form-control', 'placeholder' => 'Description'])}}
    </div>
                    