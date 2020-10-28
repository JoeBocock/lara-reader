@extends('core.frame') @section('content')

<!-- Load in some CSS to make the page look a little nicer -->
<link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}" />

<!-- RSS Form -->
<form id="rss-form">
    <fieldset>
        <div class="form-group">
            <label for="url"><h4>RSS Feed URL</h4></label>
            <input
                id="url"
                name="url"
                placeholder="https://myrssfeedexample.com/feed"
                type="text"
            />
            <div id="form-error"><small></small></div>
        </div>
        <button
            class="btn btn-primary"
            type="submit"
            role="button"
            name="submit"
            id="submit"
        >
            Submit
        </button>
    </fieldset>
</form>

<!-- If there's no feeds, display an error. -->
@empty($feeds)
<div class="terminal-alert terminal-alert-error">
    No content to show! Add a feed using the 'Add Feed' link in the navigation
    bar.
</div>
@endempty

<!-- Display the feed items -->
@foreach ($feeds as $feed) @foreach ($feed['items'] as $item)

<div class="terminal-card">
    <header>[{{ $feed['feed_title'] }}] {{ $item['title'] }}</header>
    <div class="description-container">
        <div class="terminal-alert">
            Publish Date: {{ $item['publish_date'] }}

            @if ($item['link'])
            <a
                href="{{ $item['link'] }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-primary card-button"
                >View ></a
            >
            @else
            <button type="button" class="btn btn-error card-button">
                No Link :(
            </button>
            @endif
        </div>

        {{ $item['description'] }}
    </div>
</div>

@endforeach @endforeach

<script type="text/javascript" src="{{ asset('js/core.js') }}"></script>
@endsection
