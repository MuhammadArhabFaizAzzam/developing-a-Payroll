<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">{{ $title }}</h2>
                @if(!empty($subtitle))
                    <p class="text-muted mb-0">{{ $subtitle }}</p>
                @endif
            </div>
            @if(!empty($action))
                <div>{{ $action }}</div>
            @endif
        </div>
    </div>
</div>

