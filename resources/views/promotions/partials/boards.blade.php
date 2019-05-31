<div class="well well-lg text-center Incised901Light">
    <h3 class="Incised901Light">Promotion Board Information</h3>

    <div class="text-center">
        <div class="btn-group text-center padding-bottom-10 btn-group-lg" role="group">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#enlistedBoard" aria-expanded="false" aria-controls="enlistedBoard">
                <span class="fa fa-info-circle"></span> View Enlisted Information
            </button>

            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#woBoard" aria-expanded="false" aria-controls="woBoard">
                <span class="fa fa-info-circle"></span> View Warrant Officer Information
            </button>

            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#officerBoard" aria-expanded="false" aria-controls="officerBoard">
                <span class="fa fa-info-circle"></span> View Officer Information
            </button>

            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#flagBoard" aria-expanded="false" aria-controls="flagBoard">
                <span class="fa fa-info-circle"></span> View Flag Officer Information
            </button>
        </div>
    </div>

    <div class="collapse" id="enlistedBoard">
        <div class="well well-sm text-left">
            {!! \App\Models\MedusaConfig::get('promotions.enlisted') !!}
        </div>
    </div>

    <div class="collapse" id="woBoard">
        <div class="well well-sm text-left">
            {!! \App\Models\MedusaConfig::get('promotions.warrant') !!}
        </div>
    </div>

    <div class="collapse" id="officerBoard">
        <div class="well well-sm text-left">
            {!! \App\Models\MedusaConfig::get('promotions.officer') !!}
        </div>
    </div>

    <div class="collapse" id="flagBoard">
        <div class="well well-sm text-left">
            {!! \App\Models\MedusaConfig::get('promotions.flag') !!}
        </div>
    </div>
</div>

