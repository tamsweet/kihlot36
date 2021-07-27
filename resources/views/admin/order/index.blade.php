
@include('admin.message')
<div class="row">
    <div class="col-xs-12">
        {{-- <div class="box box-primary"> --}}
            <div class="box-header with-border">
                {{-- <h3 class="box-title"> {{ __('adminstaticword.Order') }}</h3> --}}
                @if (Auth::User()->role == 'admin')
                    <a class="btn btn-info btn-md" href="{{ route('order.create') }}">
                        <i class="glyphicon glyphicon-th-l">+</i> Enroll&nbsp;User</a>
                @endif
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('adminstaticword.User') }}</th>
                                {{-- <th>{{ __('adminstaticword.Course') }}</th> --}}
                                <th>{{ __('Payment') }} {{ __('adminstaticword.Detail') }}</th>
                                {{-- <th>{{ __('adminstaticword.PaymentMethod') }}</th> --}}
                                {{-- <th>{{ __('adminstaticword.TotalAmount') }}</th> --}}
                                <th>{{ __('adminstaticword.Status') }}</th>
                                <th>{{ __('adminstaticword.View') }}</th>
                                <th>{{ __('adminstaticword.SubscriptionStatus') }}</th>
                                <th>{{ __('adminstaticword.Unenroll') }}</th>
                                <th>{{ __('adminstaticword.Delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($orders as $order)
                                <?php $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>

                                        <p><b>{{ __('adminstaticword.User') }}</b>:
                                        @if(Auth::user()->role == 'admin')
                                            @if(isset($order->user))
                                            {{ $order->user['fname'] }} {{ $order->user['lname'] }}
                                            @endif
                                        @else
                                            @if ($gsetting->hide_identity == 0)
                                                @if(isset($order->user))
                                                {{ $order->user['fname'] }} {{ $order->user['lname'] }}
                                                @endif
                                            @else
                                                Hidden
                                            @endif
                                        @endif
                                        </p>
                                        <p><b>{{ __('adminstaticword.Course') }}</b>:
                                        @if ($order->course_id != null)
                                            {{ $order->courses['title'] }}
                                        @else
                                            {{ $order->bundle['title'] }}
                                        @endif
                                        </p>
                                        
                                    </td>
                                   
                                    <td>
                                        <p><b>{{ __('adminstaticword.TransactionId') }}</b>: {{ $order->transaction_id }}</p>
                                        <p><b>{{ __('adminstaticword.PaymentMethod') }}</b>: {{ $order->payment_method }}</p>

                                        <p><b>{{ __('adminstaticword.TotalAmount') }}</b>:

                                        @if ($order->coupon_discount == !null)
                                      
                                            @if($gsetting['currency_swipe'] == 1)

                                                <i class="{{ $order->currency_icon }}"></i>{{ $order->total_amount - $order->coupon_discount }}

                                                @if ($order->subscription_id !== null)
                                                    / {{ $order->bundle->billing_interval }}
                                                @endif

                                            @else

                                                {{ $order->total_amount - $order->coupon_discount }}

                                                @if ($order->subscription_id !== null)
                                                    / {{ $order->bundle->billing_interval }}
                                                @endif

                                                <i class="{{ $order->currency_icon }}"></i>

                                            @endif

                                        

                                        @else
                                       
                                            @if($gsetting['currency_swipe'] == 1)

                                                <i class="fa {{ $order->currency_icon }}"></i>{{ $order->total_amount }}
                                                @if ($order->subscription_id !== null)
                                                    / {{ $order->bundle->billing_interval }}
                                                @endif

                                            @else

                                                {{ $order->total_amount }}
                                                @if ($order->subscription_id !== null)
                                                    / {{ $order->bundle->billing_interval }}
                                                @endif

                                                <i class="fa {{ $order->currency_icon }}"></i>

                                            @endif

                                        
                                        @endif
                                    </p>
                                        
                                    </td>
                                   
                                    <td>
                                        <form action="{{ route('order.quick', $order->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <button type="Submit"
                                                class="btn btn-xs {{ $order->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                @if ($order->status == 1)
                                                    {{ __('adminstaticword.Active') }}
                                                @else
                                                    {{ __('adminstaticword.Deactive') }}
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td><a class="btn btn-primary btn-sm"
                                            href="{{ route('view.order', $order->id) }}">{{ __('adminstaticword.View') }}</a>
                                    </td>
                                    <td>
                                        @if ($order->bundle_id != null)
                                            @if ($order->subscription_status == 'active')
                                                {{ __('adminstaticword.Active') }}
                                            @else
                                                {{ __('adminstaticword.Canceled') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if ($order->subscription_status === 'active')
                                            <form method="post"
                                                action="{{ route('stripe.cancelsubscription', ['order_id' => $order->id, 'redirect_to' => '/order']) }}"
                                                data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-fw fa-close"></i>
                                                    {{ __('adminstaticword.Unenroll') }}
                                                </button>
                                            </form>
                                        @else
                                            -
                                        @endif

                                    </td>
                                    <td>
                                        <form method="post" action="{{ url('order/' . $order->id) }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-fw fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        {{-- </div> --}}
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
   
