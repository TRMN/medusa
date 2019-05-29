@extends('layout')

@section('pageTitle')
    Eligible Promotions for {{ $chapter->chapter_name }}
@stop

@section('content')
    <h1 class="text-center">{{ $chapter->chapter_name }} members eligible for promotion</h1>

    @include('promotions.partials.boards')

    <div class="text-center padding-bottom-10">
        <button class="btn btn-primary Incised901Light btn-lg" type="button" data-toggle="collapse"
                data-target="#instructions"
                aria-expanded="false" aria-controls="instructions">
            <span class="fa fa-info-circle"></span> How to use this page
        </button>
    </div>

    <div class="collapse" id="instructions">
        <div class="well well-sm Incised901Light text-left">
            {!! str_replace('CHAPTER', $chapter->chapter_name, \App\Models\MedusaConfig::get('promotions.instructions')) !!}
        </div>
    </div>

    <div>
        @if($early || $promotable)
            {{Form::open(['id' => 'promotions', 'url' => '/bulkpromote'])}}
            {{Form::hidden('chapter', $chapter->id)}}
            {{Form::hidden('payload', null, ['id' => 'payload'])}}
        @endif

        @if (!empty($early))
            <div>
                <h2 class="text-center">Eligible for Early Promotion</h2>
                @include('promotions.partials.crewlist', ['tableId' => 'early', 'members' => $early, 'showSelect' => true])
            </div>
        @endif

        @if (!empty($promotable))
            <div>
                <h2 class="text-center">Eligible for Promotion</h2>
                @include('promotions.partials.crewlist', ['tableId' => 'promotable', 'members' => $promotable, 'showSelect' => true])
            </div>
        @endif

        @if (!empty($merit))
            <div>
                <h2 class="text-center">Eligible for Merit Promotion</h2>
                @include('promotions.partials.crewlist', ['tableId' => 'merit', 'members' => $merit, 'showSelect' => true])
            </div>
        @endif


        <div class="text-center">
            @if($early || $promotable)
                <button type="submit" class="btn btn-success" id="btnPromote">Promote the selected members</button>
                {{ Form::close() }}
            @endif
            <a href="{{route('chapter.show', [$chapter->id])}}" class="btn btn-primary"><span
                        class="fa fa-arrow-left"></span> Return to Roster</a>
        </div>


        @if(!empty($warrant))
            <div>
                <h2 class="text-center">Recommend for Warrant</h2>
                @include('promotions.partials.crewlist', ['tableId' => 'warrant', 'members' => $warrant, 'showSelect' => false])
            </div>
        @endif

        @if(!empty($board))
            <div>
                <h2 class="text-center">Eligible for Promotion Board</h2>
                @include('promotions.partials.crewlist', ['tableId' => 'board', 'members' => $board, 'showSelect' => false])
            </div>
        @endif
    </div>
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $(function () {

            $('.selectAll').on('click', function (e) {
                let table = $(this).data('target');
                if ($(this).prop('checked') === false) {
                    $('#' + table).DataTable().page.len(10).draw();
                    $('#' + table + ' [type="checkbox"]').prop("checked", false)
                } else {
                    $('#' + table).DataTable().page.len(-1).draw();
                    $('#' + table + ' [type="checkbox"]').prop("checked", true)
                }
            });

            $('#btnPromote').on('click', function (e) {
                let early = [];
                let promotable = [];
                let payload = {};

                $.each($('.early-selected:checked'), function () {
                    let elem = $(this);
                    let grade = elem.data('grade');
                    let member = elem.val();
                    early.push(
                        {
                            "memberId": member,
                            "grade": grade
                        }
                    );
                });

                $.each($('.promotable-selected:checked'), function () {
                    let elem = $(this);
                    let grade = elem.data('grade');
                    let member = elem.val();
                    promotable.push(
                        {
                            "memberId": member,
                            "grade": grade
                        }
                    );
                });

                $.each($('.merit-selected:checked'), function () {
                    let elem = $(this);
                    let grade = elem.data('grade');
                    let member = elem.val();
                    promotable.push(
                        {
                            "memberId": member,
                            "grade": grade
                        }
                    );
                });

                if (early.length) {
                    if (confirm('By clicking "Ok", you confirm that every member selected has authorized the use of promotion points for early promotion.')) {
                        payload.early = early;
                    }

                }

                if (promotable.length) {
                    payload.promotable = promotable;
                }

                if (early.length || promotable.length) {
                    $('#payload').val(JSON.stringify(payload));
                    $('#promotions').submit();
                }
            });

        });
    </script>
@stop
