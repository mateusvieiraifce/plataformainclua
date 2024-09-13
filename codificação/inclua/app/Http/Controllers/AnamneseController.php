<?php

namespace App\Http\Controllers;

use App\Models\Anamnese;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AnamneseController extends Controller
{
    public function create($paciente_id)
    {
        return view('userPaciente.anamnese.form', ['paciente_id' => $paciente_id]);
    }

    public function store(Request $request)
    {
        $rules = [
            "paciente_id" => "required|unique:anamneses,paciente_id"
        ];
        $feedbacks = [
            'paciente_id.unique' => "O paciente já realizou anamnese"
        ];
        session()->flash('msg', ['valor' => trans("O paciente já realizou anamnese."), 'tipo' => 'danger']);
        $request->validate($rules, $feedbacks);

        $atividade_fisicas = $request->atividade_fisicas;
        /* CONVERTER CHECKBOX EM UMA UNICA STRING */
        if (is_array($request->atividade_fisicas)) {
            $atividade_fisicas = implode(', ', $request->atividade_fisicas);
        }
        
        $participa_atividades = $request->participa_atividades;
        /* CONVERTER CHECKBOX EM UMA UNICA STRING */
        if (is_array($request->participa_atividades)) {
            $participa_atividades = implode(', ', $request->participa_atividades);
        }
        
        try {
            $anamnese = new Anamnese();
            $anamnese->paciente_id = $request->paciente_id;
            $anamnese->gravidez_programada = $request->gravidez_programada;
            $anamnese->idade_mae_geracao = $request->idade_mae_geracao;
            $anamnese->idade_pai_geracao = $request->idade_pai_geracao;
            $anamnese->pre_natal = $request->pre_natal;
            $anamnese->posicao_ordem_gestacao = $request->posicao_ordem_gestacao;
            $anamnese->tentativa_aborto = $request->tentativa_aborto;
            $anamnese->exposicao_raios = $request->exposicao_raios;
            $anamnese->fatos_ocorridos = $request->fatos_ocorridos;
            $anamnese->local_parto = $request->local_parto;
            $anamnese->fez_parto = $request->fez_parto;
            $anamnese->tipo_parto = $request->tipo_parto;
            $anamnese->parto_prematuro = $request->parto_prematuro;
            $anamnese->problemas_parto = $request->problemas_parto;
            $anamnese->crianca_bem_recebida = $request->crianca_bem_recebida;
            $anamnese->amamentacao = $request->amamentacao;
            $anamnese->comeu_pastoso_solido = $request->comeu_pastoso_solido;
            $anamnese->tomou_todas_vacinas = $request->tomou_todas_vacinas;
            $anamnese->permanencia_tres_anos = $request->permanencia_tres_anos;
            $anamnese->iniciou_sustentacao_cabeca = $request->iniciou_sustentacao_cabeca;
            $anamnese->idade_sentou_so = $request->idade_sentou_so;
            $anamnese->idade_engatinhou = $request->idade_engatinhou;
            $anamnese->idade_andou = $request->idade_andou;
            $anamnese->corre_naturalidade = $request->corre_naturalidade;
            $anamnese->cai_facilidade = $request->cai_facilidade;
            $anamnese->anda_naturalidade = $request->anda_naturalidade;
            $anamnese->dominancia_lateral = $request->dominancia_lateral;
            $anamnese->atividade_fisicas = $atividade_fisicas;
            $anamnese->comecou_falar = $request->comecou_falar;
            $anamnese->teve_gagueira = $request->teve_gagueira;
            $anamnese->dificuldade_fala = $request->dificuldade_fala;
            $anamnese->problema_visao_audicao_fala = $request->problema_visao_audicao_fala;
            $anamnese->fala_corretamente = $request->fala_corretamente;
            $anamnese->gosta_conversar = $request->gosta_conversar;
            $anamnese->conta_historias = $request->conta_historias;
            $anamnese->conversa_adultos = $request->conversa_adultos;
            $anamnese->inventa_casos = $request->inventa_casos;
            $anamnese->sabe_cantar = $request->sabe_cantar;
            $anamnese->gosta_musicas = $request->gosta_musicas;
            $anamnese->doencas_contraidas = $request->doencas_contraidas;
            $anamnese->teve_febre_convulsao = $request->teve_febre_convulsao;
            $anamnese->teve_queda_acidente = $request->teve_queda_acidente;
            $anamnese->fez_exame_neurologico = $request->fez_exame_neurologico;
            $anamnese->toma_medicamento_controlado = $request->toma_medicamento_controlado;
            $anamnese->remedios_controlados = $request->remedios_controlados;
            $anamnese->alergico = $request->alergico;
            $anamnese->apresenta_deficiencia_fisica = $request->apresenta_deficiencia_fisica;
            $anamnese->dificuldade_relacionar_deficiencia = $request->dificuldade_relacionar_deficiencia;
            $anamnese->deficiencia_intelectual_familia = $request->deficiencia_intelectual_familia;
            $anamnese->aprendeu_usar_sanitario = $request->aprendeu_usar_sanitario;
            $anamnese->teve_enurese_noturna = $request->teve_enurese_noturna;
            $anamnese->teve_enurese_idade = $request->teve_enurese_idade;
            $anamnese->atitude_pais_enurese = $request->atitude_pais_enurese;
            $anamnese->onde_dorme = $request->onde_dorme;
            $anamnese->com_quem_dorme = $request->com_quem_dorme;
            $anamnese->tipo_sono = $request->tipo_sono;
            $anamnese->conversa_dormindo = $request->conversa_dormindo;
            $anamnese->range_dentes_dormindo = $request->range_dentes_dormindo;
            $anamnese->quando_dorme = $request->quando_dorme;
            $anamnese->habitos_dormir = $request->habitos_dormir;
            $anamnese->atitude_pais_habitos_dormir = $request->atitude_pais_habitos_dormir;
            $anamnese->adotado_legitimo = $request->adotado_legitimo;
            $anamnese->sabe_adocao = $request->sabe_adocao;
            $anamnese->aceita_adocao = $request->aceita_adocao;
            $anamnese->diz_deseja_ser_crescer = $request->diz_deseja_ser_crescer;
            $anamnese->desejo_familia_crianca = $request->desejo_familia_crianca;
            $anamnese->compreensao_familia_comportamento = $request->compreensao_familia_comportamento;
            $anamnese->bom_relacionamento_familia = $request->bom_relacionamento_familia;
            $anamnese->ciumes_irmaos = $request->ciumes_irmaos;
            $anamnese->apresenta_agressividade = $request->apresenta_agressividade;
            $anamnese->irrita_facilmente = $request->irrita_facilmente;
            $anamnese->obediente = $request->obediente;
            $anamnese->faz_perguntas_dificeis = $request->faz_perguntas_dificeis;
            $anamnese->busca_atencao = $request->busca_atencao;
            $anamnese->presencia_violencia = $request->presencia_violencia;
            $anamnese->habitos_alimentares = $request->habitos_alimentares;
            $anamnese->hobby = $request->hobby;
            $anamnese->participa_atividades = $participa_atividades;
            $anamnese->possui_amigos = $request->possui_amigos;
            $anamnese->prefere_ficar_so = $request->prefere_ficar_so;
            $anamnese->com_quem_brinca = $request->com_quem_brinca;
            $anamnese->cuidadoso_desligado = $request->cuidadoso_desligado;
            $anamnese->brinquendo_preferido = $request->brinquendo_preferido;
            $anamnese->save();
            
            $msg = ['valor' => trans("Anamnese realizada com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Houve um erro ao salvar os dados. Tente novamente!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back()->withInput();
        }
        
        return redirect()->route('paciente.minhasconsultas');
    }
}
