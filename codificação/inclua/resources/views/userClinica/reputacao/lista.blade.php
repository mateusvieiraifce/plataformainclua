@extends('layouts.app', ['page' => __('Reputação'), 'exibirPesquisa' => false, 'pageSlug' => 'reputacao', 'class' => 'reputacao'])
@section('title', 'Reputação')
@section('content')
    <div class="row">
       

        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Reputação</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <h6>Média Geral: {{ number_format($mediaNotas, 2, ',') }}</h6>
                        @if(sizeof($avaliacoes) > 0)
                            <table class="table">
                                <thead>                                  
                                    <th>Comentário</th>
                                    <th ></th>                                   
                                </thead>
                                <tbody>
                                     @php
                                     $cont = 0;
                                     @endphp
                                    @foreach($avaliacoes as $avaliacao)
                                   
                                     @if($cont % 4==0)
                                        <tr>
                                            <td>
                                                {{ $avaliacao->comentario }}
                                            </td>
                                            <td colspan="4">  
                                    @endif
                                            @php
                                            $cont = $cont + 1;
                                            @endphp
                                            
                                                <div class="star-rating" style="font-size: 8px;!important"> 
                                                    <div class="row" style="overflow: hidden;">                                                                                                     
                                                            <label style="float: left; margin: 0; font-size: 8px;!important"> {{ $avaliacao->categoria }}     </label>                            
                                                            <label style="float: left; margin-right: 10px; font-size: 8px;!important"> </label>                           
                                                            @for ($i = 1; $i <= $avaliacao->nota; $i++)
                                                                <label class="star selected" style="float: right; margin: 0; font-size: 8px;!important" >&#9733;</label>
                                                            @endfor                                                     
                                                    </div>
                                                </div>                                         
                                           
                                            @if($cont % 4==0)
                                            </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                </tbody>
                            </table>
                           {{ $avaliacoes->appends(request()->query())->links() }}
                        @else
                            <h5>Ainda não há nenhuma avaliação.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Reputação</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <h6>Média Geral: {{ number_format($mediaNotas, 2, ',') }}</h6>
                        @if(sizeof($avaliacoes) > 0)
                            <table class="table">
                                <thead>
                                    <th>Categoria</th>
                                    <th>Média</th>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>
                                               Limpeza
                                            </td>
                                            <td>
                                               {{ number_format($mediaNotasCategoriaLimpeza, 2, ',') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               Localização
                                            </td>
                                            <td>
                                               {{ number_format($mediaNotasCategoriaLocalizacao, 2, ',') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               Organização
                                            </td>
                                            <td>
                                               {{ number_format($mediaNotasCategoriaOrganizacao, 2, ',') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               Tempo de espera
                                            </td>
                                            <td>
                                               {{ number_format($mediaNotasCategoriaTempo, 2, ',') }}
                                            </td>
                                        </tr>    
                                </tbody>
                            </table>                          
                        @else
                            <h5>Ainda não há nenhuma avaliação.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
