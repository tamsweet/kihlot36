@extends('admin/layouts.master')
@section('title', 'All Meetings - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.Meetings') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped table-responsive">

            <thead>
             
              <tr>
                <th>#</th>
                <th>{{ __('adminstaticword.User') }}</th>
                <th>{{ __('adminstaticword.Meeting') }}</th>
                <th>{{ __('adminstaticword.Url') }}</th>
                <th>{{ __('adminstaticword.Delete') }}</th>
                
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($allgooglemeet as $meeting)
              <?php $i++;?>
              <tr>
                <td><?php echo $i;?></td>
              
                <td>{{$meeting->user['fname']}}</td>

                <td>
                  <p><b>{{ __('adminstaticword.MeetingID') }}:</b> {{ $meeting['meeting_id'] }}</p>
                  <p><b>{{ __('adminstaticword.OwnerID') }}:</b> {{ $meeting['owner_id'] }}</p>
                  <p><b>{{ __('adminstaticword.MeetingTopic') }}:</b> {{ $meeting['meeting_title'] }}</p>
                  <p><b>{{ __('adminstaticword.StartTime') }}:</b> {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</p>

                  @if(isset($meeting->course_id))

                  <p><b>{{ __('adminstaticword.Meetingoncourse') }}:</b> {{ $meeting->courses['title'] }}</p>

                  @endif

                </td>

                <td>
              <a href="{{ $meeting['meet_url'] }}" target="_blank" class="btn btn-primary">Join Meeting</a>
            </td>

            <td><form  method="post" action="{{ route('googlemeet.delete',$meeting['meeting_id']) }}
                "data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                 
                  <button onclick="return confirm('Are you sure you want to delete?')"  type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash-o"></i></button>
                </form>
            </td>
                
              
                

                @endforeach
             
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

@endsection
