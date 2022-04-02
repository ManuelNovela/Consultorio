<div>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3><strong>Informacoes dos Pacientes</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="float: left;"><strong>Todos Pacientes</strong></h5>
                        <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal" data-target="#addPatientModal">Adicionar Novo Paciente</button>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}</div>
                        @endif


                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="search" class="form-control w-25" placeholder="Pesquisar" wire:model="searchTerm" style="float: right;" />
                            </div>
                        </div>


                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Data de Nascimento</th>
                                <th>Sexo</th>
                                <th>Telefone</th>
                                <!--<th>Profissão
                                <th>Endereço</th>
                                <th>Possui Seguro</th>-->
                                <th style="text-align: center;">Accoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($patients->count() > 0)
                                @foreach ($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->id }}</td>
                                        <td>{{ $patient->name }}</td>
                                        <td>{{ $patient->birthDate }}</td>
                                        <td>{{ $patient->gender}}</td>
                                        <td>{{ $patient->telephone }}</td>
                                        <!--<td>{{ $patient->profession }}</td>
                                        <td>{{ $patient->address }}</td>
                                        <td>{{ $patient->hasInsurance }}</td> -->
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-secondary" wire:click="viewPatientDetails({{ $patient->id }})">Mostrar</button>
                                            <button class="btn btn-sm btn-primary"   wire:click="editPatient({{ $patient->id }})">Editar</button>
                                            <button class="btn btn-sm btn-danger"    wire:click="deleteConfirmation({{ $patient->id }})">Deletar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center;"><small>Nenhum paciente foi encontrado!</small></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addPatientModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registar Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form wire:submit.prevent="storePatientData">


                        <div class="form-group row">
                            <label for="name" class="col-3">Nome</label>
                            <div class="col-9">
                                <input type="text" id="name" class="form-control" wire:model="name">
                                @error('name')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthDate" class="col-3">Data de Nascimento</label>
                            <div class="col-9">
                                <input type="datetime-local" id="birthDate" class="form-control" wire:model="birthDate">
                                @error('birthDate')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-3">Sexo</label>
                            <div class="col-9">
                                <input type="text" id="gender" class="form-control" wire:model="gender">
                                @error('gender')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telephone" class="col-3">Telefone</label>
                            <div class="col-9">
                                <input type="number" id="telephone" class="form-control" wire:model="telephone">
                                @error('telephone')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profession" class="col-3">Profissao</label>
                            <div class="col-9">
                                <input type="text" id="profession" class="form-control" wire:model="profession">
                                @error('profession')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-3">Endereco</label>
                            <div class="col-9">
                                <input type="text" id="address" class="form-control" wire:model="address">
                                @error('address')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hasInsurance" class="col-3">Tem Seguro?</label>
                            <div class="col-9">
                                <input type="checkbox" id="hasInsurance" class="form-control" wire:model="hasInsurance">
                                @error('hasInsurance')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Gravar Dados</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="editPatientModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Registro do Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form wire:submit.prevent="editPatientData">

                        <div class="form-group row">
                            <label for="name" class="col-3">Nome</label>
                            <div class="col-9">
                                <input type="text" id="name" class="form-control" wire:model="name">
                                @error('name')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthDate" class="col-3">Data de Nascimento</label>
                            <div class="col-9">
                                <input type="datetime-local" id="birthDate" class="form-control" wire:model="birthDate">
                                @error('birthDate')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-3">Sexo</label>
                            <div class="col-9">
                                <input type="text" id="gender" class="form-control" wire:model="gender">
                                @error('gender')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telephone" class="col-3">Telefone</label>
                            <div class="col-9">
                                <input type="number" id="telephone" class="form-control" wire:model="telephone">
                                @error('telephone')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profession" class="col-3">Profissao</label>
                            <div class="col-9">
                                <input type="text" id="profession" class="form-control" wire:model="profession">
                                @error('profession')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-3">Endereco</label>
                            <div class="col-9">
                                <input type="text" id="address" class="form-control" wire:model="address">
                                @error('address')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hasInsurance" class="col-3">Tem Seguro?</label>
                            <div class="col-9">
                                <input type="checkbox" id="hasInsurance" class="form-control" wire:model="hasInsurance">
                                @error('hasInsurance')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Gravar Dados</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="deletePatientModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmação de excluir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Tem certeza de que quer eliminar o registro deste paciente ?</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button class="btn btn-sm btn-danger" wire:click="deletePatientData()">Sim! Confirmo</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="viewPatientModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informação do paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInputs()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>

                        <tr>
                            <th>ID: </th>
                            <td>{{ $patient_id }}</td>
                        </tr>

                        <tr>
                            <th>Nome: </th>
                            <td>{{ $name }}</td>
                        </tr>


                        <tr>
                            <th>Data de Nascimento: </th>
                            <td>{{ $birthDate }}</td>
                        </tr>


                        <tr>
                            <th>Sexo: </th>
                            <td>{{ $gender}}</td>
                        </tr>

                        <tr>
                            <th>Telefone: </th>
                            <td>{{ $telephone }}</td>
                        </tr>

                        <tr>
                            <th>Profissao: </th>
                            <td>{{ $profession }}</td>
                        </tr>

                        <tr>
                            <th>Tem seguro? </th>
                            <td>@if($hasInsurance)
                                    Sim
                                @else
                                    Nao
                                @endif
                            </td>
                        </tr>





                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        window.addEventListener('close-modal', event =>{
            $('#addPatientModal').modal('hide');
            $('#editPatientModal').modal('hide');
            $('#deletePatientModal').modal('hide');
        });


        window.addEventListener('show-edit-patient-modal', event =>{
            $('#editPatientModal').modal('show');
        });


        window.addEventListener('show-delete-confirmation-modal', event =>{
            $('#deletePatientModal').modal('show');
        });


        window.addEventListener('show-view-patient-modal', event =>{
            $('#viewPatientModal').modal('show');
        });
    </script>
@endpush
