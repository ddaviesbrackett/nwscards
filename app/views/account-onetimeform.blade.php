<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title" id="onetimeLabel">Extra Cards</h4>
</div>
<div class="modal-body">
  <p>
    Your regular order is:
    <ul>
      @if($user->saveon > 0)<li> ${{$user->saveon}}00 from Save-On </li>@endif
      @if($user->coop > 0)<li> ${{$user->coop}}00 from the Kootenay Co-Op</li>@endif
      </ul>
      Cards below will be added to <b>to your next order only</b>.  Want more options?  <a href="/edit">Edit your order</a>.
  </p>
  {{Form::model($user, ['route'=>['account-postonetime'], 'method'=>'POST', 'class'=>'form-horizontal onetime'])}}
    <div class='form-group'>
      <label for='coop_onetime' class='col-sm-12'>Kootenay Co-op:</label>
      <div class='col-sm-6'>
        <div class="input-group" style="margin:10px 0;">
          {{ Form::input('number', 'coop_onetime', null, array('class' => 'form-control')) }}
          <span class="input-group-addon">x $100</span>
        </div>
      </div>
      <div class='col-sm-6'>
        <div class="alert alert-warning alert-dismissible hidden" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          That's $<span class="amt"></span>00 in cards!
        </div>
      </div>
    </div>
    <div class='form-group'>
      <label for='saveon_onetime' class='col-sm-12'>Save-On:</label>
      <div class='col-sm-6'>
        <div class="input-group" style="margin:10px 0;">
          {{ Form::input('number', 'saveon_onetime', null, array('class' => 'form-control')) }}
          <span class="input-group-addon">x $100</span>
        </div>
      </div>
      <div class='col-sm-6'>
        <div class="alert alert-warning alert-dismissible hidden" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          That's $<span class="amt"></span>00 in cards!
        </div>
      </div>
    </div>
    <div class="form-group text-right">
      <div class="col-sm-12">
        <button type='submit' class='btn btn-danger btn-lg'>Save</button>
      </div>
    </div>
  {{Form::close()}}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>