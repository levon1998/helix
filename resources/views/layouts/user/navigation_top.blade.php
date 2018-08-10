<div class="row border-bottom">
    <style>
        .overflow-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">

        @if(session()->get('crew')['status'] == 'passive')
            <div class="panel panel-warning copyright-wrap" id="copyright-wrap">
                <div class="panel-heading">
                    <button type="button" class="close" data-target="#copyright-wrap" data-dismiss="alert"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-warning"></i> The current crew not yet approved. Please configure all crew data,
                    and then
                    contact with administration.
                </div>
            </div>
        @endif

        <div class="navbar-header">

        </div>

    </nav>
</div>