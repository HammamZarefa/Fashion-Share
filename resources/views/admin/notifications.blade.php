@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-lg-7 col-md-3 mb-30">
            <div class="card b-radius--5">
                <div class="card-body p-0">
                    @foreach($adminNotifications as $notification)
                    <a href="{{ route('admin.notification.read',$notification->id) }}" class="dropdown-menu__item">
                      <div class="d-flex p-2">
                        <div class="navbar-notifi__left bg--green b-radius--rounded"><img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.@$notification->user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('Profile Image')"></div>
                        <div class="navbar-notifi__right">
                          <h6 class="notifi__title">{{ __($notification->title) }}   </h6>
                          <span class="time"><i style="margin-right: 10px" class="far fa-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                      </div><!-- navbar-notifi end -->
                    </a>
                    @endforeach



                 


                     
                </div>
            </div>
        </div>
    </div>
    
   
@endsection
