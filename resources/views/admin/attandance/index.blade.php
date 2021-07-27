

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
                <th>{{ __('adminstaticword.Course') }}</th>
                <th>{{ __('adminstaticword.UsersEnrolled') }}</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($courses as $course)
              <?php $i++;?>
              <tr>
                <td><?php echo $i;?></td>
              
                <td>
                  <p><b>{{ __('adminstaticword.course') }}:</b> {{ $course['title'] }}</p>
                 
                </td>
                <td>
                  <a href="{{ route('enrolled.users',$course->id) }}" class="btn btn-primary">{{ __('adminstaticword.UsersEnrolled') }}</a>
                </td>
                

                @endforeach
             
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
     
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

