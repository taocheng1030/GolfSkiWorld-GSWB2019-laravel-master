    <div class="box-body box-profile">
        {{ HTML::image($user->avatar, $user->name, ['class' => 'profile-user-img img-responsive img-circle']) }}
        <h3 class="profile-username text-center">{{ $user->name }}</h3>

        <div class="list-group list-group-unbordered">
            <a href="{{ adminUrl('profile/summary/followers') }}" class="list-group-item">
                <b>Followers</b>
                <span class="pull-right"><span class="label label-info">{{ $user->followers->count() }}</span></span>
            </a>
            <a href="{{ adminUrl('profile/summary/following') }}" class="list-group-item">
                <b>Following</b>
                <span class="pull-right"><span class="label label-info">{{ $user->following->count() }}</span></span>
            </a>
            {{--<a href="{{ adminUrl('profile/summary/liked') }}" class="list-group-item">--}}
                {{--<b>Liked</b>--}}
                {{--<span class="pull-right"><span class="label label-success">{{ $user->likedFiles->count() }}</span></span>--}}
            {{--</a>--}}
            <li class="list-group-item">
                <b>Liked</b>
                <span class="pull-right"><span class="label label-success">{{ $user->likedFiles->count() }}</span></span>
            </li>
        </div>
    </div>
