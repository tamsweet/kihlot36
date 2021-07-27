

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped table-responsive">
             
            <thead>
             
              <tr>
                <th>#</th>
                <th>{{ __('adminstaticword.User') }}</th>
                <th>{{ __('Class') }}</th>
                <th>{{ __('adminstaticword.UsersEnrolled') }}</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($live_attandance as $course)
                <?php $i++;?>
                <tr>
                  <td><?php echo $i;?></td>

                  <td>
                    <p><b></b> {{ $course->user['fname'] }}</p>
                   
                  </td>
                
                  <td>
                    @if($course->zoom_id != NULL)
                    <p><b></b> {{ $course->zoom['meeting_title'] }}</p>
                    @endif
                    @if($course->bbl_id != NULL)
                    <p><b></b> {{ $course->bbl['meetingname'] }}</p>
                    @endif
                    @if($course->jitsi_id != NULL)
                    <p><b></b> {{ $course->jitsi['meeting_title'] }}</p>
                    @endif
                    @if($course->google_id != NULL)
                    <p><b></b> {{ $course->google['meeting_title'] }}</p>
                    @endif
                   
                  </td>
                  <td>
                  	<p><b>{{ __('adminstaticword.Attandance') }}: </b>{{ date('d-m-Y', strtotime($course->date)) }} </p>
                  </td>
                </tr>
              @endforeach
             
              
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
     
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

