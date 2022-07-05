<div class="tweet">
    <div class="user">
        <a href="profile.php?user_id=1">
            <!-- 投稿があった際に投稿した人のアイコン画像を表示している。 -->
            @if( isset($view_tweet->user_image) )
            <img src="{{ asset('storage/icon/' . $view_tweet->user_image) }}" />
            @endif
        </a>
    </div>
    <div class="content">
        <div class="name">
            <a href="profile.php?user_id={{ $view_tweet->user_id }}">
                <span class="nickname">{{ $view_tweet->user_nickname }}</span>
                <span class="user-name">{{ '@'.$view_tweet->user_name }} ・{{ convertToDayTimeAgo ($view_tweet->updated_at ); }}</span>
            </a>
        </div>

        <p>{{ $view_tweet->tweet_body }}</p>
        <!-- 投稿があった際に画像を投稿した人は表示される。 -->
        @if( isset($view_tweet->tweet_image_name) )
        <img src="{{ asset('storage/' . $view_tweet->tweet_image_name) }}" />
       {{-- <img src="{{ buildImagePath($view_tweet->tweet_image_name, 'tweet') }}" alt="" class="post-image">--}}
        @endif
        <div class="icon-list">
        <div class="like js-like"  data-tweet-id="{{ htmlspecialchars($view_tweet->tweet_id) }}" data-like-id="{{ htmlspecialchars($view_tweet->like_id) }}" >
                @if (isset($view_tweet->like_id))
                <!-- // いいね！している場合 -->
                <img src="/icon/img/icon-heart-twitterblue.svg" alt="">
                @else
                <img id='increment' src="/icon/img/icon-heart.svg" alt="">
                @endif
            </div>
            {{--<p>{{'良いね数!'. $view_tweet->like_id }}</p>--}}
            <div class="like-count js-like-count">{{ htmlspecialchars($view_tweet->like_count); }}
            </div>
        </div>
    </div>
</div>
</div>