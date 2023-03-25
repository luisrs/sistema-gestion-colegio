export function Card({header='', body='', href=''}){

    return (
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"> {header} Año - Registro de notas</h6>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                        class="fas fa-download fa-sm text-white"></i> {href} Descargar PDF</a>
                    </div>
                    <div class="card-body">
                        {body}
                    </div>
                </div>
        </div>


    )
}