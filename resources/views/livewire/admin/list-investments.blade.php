<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small"><span class="goback"><i class="right fas fa-angle-left"></i></span></li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><button wire:loading.attr="disabled" wire:click.prevent="addModal" class="btn  btn-primary ">
                            <i class="fas fa-plus-circle"></i> Add New</button></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item active "><a class="nav-link" href="#info" data-toggle="tab">Add New</a></li>
                                <li class="nav-item"><a class="nav-link" href="#password-tab" data-toggle="tab">Active</a></li>
                                <li class="nav-item"><a class="nav-link" href="#password-tab" data-toggle="tab">Completed</a></li>
                                <li class="nav-item"><a class="nav-link" href="#password-tab" data-toggle="tab">Terminated</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                list
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>