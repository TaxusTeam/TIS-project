<div class="row rp-box js__runner-box--{{ $runner->id }} rp-box--runner">
    <div class="col-xs-12 rp-box__row--header {{ $runner->runner___is_winner ? "runners__header--gold" : "runners__header--standard" }}">
        <div class="rp-box__header--name">
            {{ $runner->users___name }}
        </div>
        <div class="rp-box__header--distance_text">
            {{ $runner->total_distance / 1000 }} km
        </div>
    </div>
    <div class="col-xs-12 rp-box__row--description">
        <div class="runner__description--text">
            Sa prihlásil dňa <strong>{{ date("d. m. Y", strtotime($runner->start)) }}</strong> <br />
            @if($runner->runner___is_winner)
                Do cieľa dobehol dňa <strong>{{ date("d. m. Y", strtotime($runner->finish)) }}</strong>
            @else
                A ešte stále beží...
            @endif
        </div>
        <img src="/uploads/avatars/{{ Auth::user()->avatar }}" alt="avatar" class="runner__description--img" />
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".js__runner-box--{{ $runner->id }} .rp-box__row--description").hide();

        $(".js__runner-box--{{ $runner->id }}").hover(function () {
            $(this).find(".rp-box__row--description").show(500);
        }, function () {
//            $(this).find(".rp-box__row--description").hide(500);
        });
    });
</script>

