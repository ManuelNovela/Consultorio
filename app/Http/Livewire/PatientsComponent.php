<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use phpDocumentor\Reflection\Types\This;


class PatientsComponent extends Component
{

    //Atributos do Paciente
    public $patient_id, $name, $birthDate, $telephone, $gender, $address, $profession, $hasInsurance;
    public $searchTerm; //variavel de busca || filtro


    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'birthDate' => 'required',
            'telephone' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'profession' => 'required',


        ]);
    }


    public function storePatientData()
    {
        //validar on submit do form
        $this->validate([
            'name' => 'required',
            'birthDate' => 'required',
            'telephone' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'profession' => 'required',
        ]);


        //Iniciar a instancia paciente com os dados validados.
        $patient = new Patient();
        $patient->name = $this->name;
        $patient->birthDate = $this->birthDate;
        $patient->telephone = $this->telephone;
        $patient->gender = $this->gender;
        $patient->address = $this->address;
        $patient->profession = $this->profession;
        $patient->hasInsurance = $this->hasInsurance;

        $patient->save();

        //enviar a mensagem de sucesso.
        session()->flash('message', 'Paciente Registado com sucesso!');

        //limpar os dados das variaveis publicas;
        $this->resetInputs();

        //Fechar modal depois de registar o novo paciente
        $this->dispatchBrowserEvent('close-modal');
    }

    //limpar os dados das variaveis publicas depois de feitas Accoes de CRUD.
    public function resetInputs()
    {
        $this->name= '';
        $this->birthDate= '';
        $this->telephone= '';
        $this->gender= '';
        $this->address= '';
        $this->profession= '';
    }

    //sempre que um modal de accoes e fechado, limpar os inputs
    public function close()
    {
        $this->resetInputs();
    }


    //Carregaer dados do paciente e mostrar no modal
    public function editPatient($id)
    {
        $this->loadPatientData($id);
        //acionar modal
        $this->dispatchBrowserEvent('show-edit-patient-modal');
    }

    //update dos dados do pacient
    public function editPatientData()
    {
        //validar on submit do form
        $this->validate([
            'name' => 'required',
            'birthDate' => 'required',
            'telephone' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'profession' => 'required',
        ]);

        //Iniciar a instancia paciente com os dados validados.
        $patient = Patient::where('id', $this->patient_id )->first();
        $patient->name = $this->name;
        $patient->birthDate = $this->birthDate;
        $patient->telephone = $this->telephone;
        $patient->gender = $this->gender;
        $patient->address = $this->address;
        $patient->profession = $this->profession;
        $patient->hasInsurance = $this->hasInsurance;

        $patient->save();


        session()->flash('message', 'Dados do Paciente editados com sucesso!');


        //Fechar modal no final da accao de editar
        $this->dispatchBrowserEvent('close-modal');
    }


    //Hold id do paciente e espera confirmacao de apagar os dados.
    public function deleteConfirmation($id)
    {
        $this->patient_id = $id; //patient id

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    // "eliminar" registro
    public function deletePatientData()
    {
        $patient = Patient::where('id', $this->patient_id)->first();

        //opcionar
        $patient->delete();

        //resposta possitiva
        session()->flash('message', 'O registro foi eliminado com sucesso!');

        $this->dispatchBrowserEvent('close-modal');
        $this->patient_id = '';
    }


    public function cancel()
    {
        $this->student_delete_id = '';
    }


    public function viewPatientDetails($id)
    {
        $patient = Patient::where('id', $id)->first();

        $this->loadPatientData($id);

        $this->dispatchBrowserEvent('show-view-patient-modal');
    }


    /**
     * @param $id
     * Carrega os dados do Paciente do banco de dados para as variaveis publicas
     */
    public function loadPatientData($id){
        $patient = Patient::where('id', $id)->first();
        $this->patient_id = $patient->id;
        $this->name = $patient->name;
        $this->birthDate = $patient->birthDate;
        $this->telephone = $patient->telephone;
        $this->gender = $patient->gender;
        $this->address= $patient->address;
        $this->profession = $patient->profession;
        $this->hasInsurance = $patient->hasInsurance;
    }


    public function render()
    {
        //Get all patients
        $patients = Patient::where('name', 'like', '%'.$this->searchTerm.'%')->orWhere('telephone', 'like', '%'.$this->searchTerm.'%')->orWhere('id', 'like', '%'.$this->searchTerm.'%')->get();

        return view('livewire.patients-component', ['patients'=>$patients])->layout('livewire.layouts.base');
    }
}

