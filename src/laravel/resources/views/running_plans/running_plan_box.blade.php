<a href="{{ route('running_plan.show', $runningPlan->id) }}">
    <div class="row rp-box js__rp-box--{{ $runningPlan->id }}">
        <div class="col-xs-12 rp-box__row--header">
            <div class="rp-box__header--name">
                {{ $runningPlan->name }}
            </div>
            <div class="rp-box__header--distance_text">
                {{ $runningPlan->distance_text }}
            </div>
        </div>
        <div class="col-xs-12 rp-box__row--description">
            {{ $runningPlan->description }}
        </div>
        <div class="col-xs-12 rp-box__row--group">
            skupina: <span class="rp-box__span--group">{{ $groups[ $runningPlan->group_id ] }}</span>
        </div>
    </div>
</a>

<script>
    $(document).ready(function() {
        $(".js__rp-box--{{ $runningPlan->id }} .rp-box__row--description").hide();

        $(".js__rp-box--{{ $runningPlan->id }}").hover(function () {
            $(this).find(".rp-box__row--description").show(500);
        }, function () {
//            $(this).find(".rp-box__row--description").hide(500);
        });
    });
</script>