<div id="{{ wp_unique_prefixed_id('readspeaker_button_') }}" class="rs_skip rsbtn rs_preserve">
    <a rel="nofollow" class="rsbtn_play" title="Laat de tekst voorlezen met ReadSpeaker webReader"
        href="https://app-eu.readspeaker.com/cgi-bin/rsent?customerid={{ $customerId }}&amp;lang=nl_nl&amp;readid={{ $readId }}&amp;url={{ rawurlencode(get_permalink()) }}">
        <span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Lees voor</span></span></span>
        <span class="rsbtn_right rsimg rsplay rspart"></span>
    </a>
</div>
