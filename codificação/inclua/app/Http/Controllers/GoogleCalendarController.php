<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Consulta;
use App\Models\Endereco;
use App\Models\Especialista;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GoogleCalendarController extends Controller
{
    private $service;
    private $calendarId;

    public function __construct()
    {
        $this->calendarId = env('GOOGLE_CALENDAR_ID', 'primary');
        $this->initializeCalendarService();
    }

    private function initializeCalendarService()
    {
        $client = new Client();

        // Configuração do Service Account
        $client->setAuthConfig(storage_path('app/google-calendar/service-account.json'));
        $client->addScope(Calendar::CALENDAR);


        // Para G Suite domains, descomente e defina o usuário a ser impersonado
        $client->setSubject('admin@plataformainclua.com');

        $this->service = new Calendar($client);
    }

    /**
     * Cria um novo evento no calendário
     */
    public function createEvent(Request $request)
    {
        $validated = $this->validateEventRequest($request);

        try {
            $event = $this->buildEvent($validated);
            $createdEvent = $this->service->events->insert($this->calendarId, $event);

            return response()->json([
                'success' => true,
                'event' => $this->formatEventResponse($createdEvent)
            ]);

        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function createEventGet($idConsulta=1)
    {
        date_default_timezone_set('America/Sao_Paulo');


        $consulta = Consulta::find($idConsulta);

        if  ($consulta == null){
            return "";
        }

        if  ($consulta->convite){
            return "";
        }
        //dd("aqui");

        $clinica = Clinica::find($consulta->clinica_id);
        if ($clinica == null){
            return  "";
        }
        $paciente = Paciente::find($consulta->paciente_id);
        //dd();
        if ($paciente == null){
            return "";
        }


        $endereco = Endereco::where("user_id",$clinica->usuario_id)->where('principal',true)->first();
        $especialista = Especialista::find($consulta->especialista_id);
      //  dd($especialista->especialidade->descricao, );
      //  dd();
// Obter data/hora atual

        $agora = Carbon::parse($consulta->horario_agendado);
       // dd($agora);
       // $validated = $this->validateEventRequest($request);
        $validated = [];
        $validated['title'] = "Consulta com  " .  $especialista->especialidade->descricao  ;

        if (!$consulta->remota) {

            $enderecoCompleto = sprintf(
                "%s, %s, %s - %s",
                $endereco->rua,
                $endereco['numero'],
                $endereco['cidade'],
                $endereco['estado']
            );
         //   dd($enderecoCompleto);
            $validated['location'] = $enderecoCompleto;
            $validated["remota"] = false;
        }else{
            $validated["remota"] = true;
        }
        $validated['description'] = $validated['title']  . ", ". $especialista->user->nome_completo .", na clínica " .$clinica->nome ;
        $validated['start_time'] = $agora->toIso8601String();
        $final = $agora->addMinute($consulta->tempo);

      //  $final->modify('+30 minutes');
        $validated['end_time'] = $final->toIso8601String();
        $emailPaciente =$paciente->user->email;
        $emailClinica = $clinica->getUser->email;
        $emailEspecialista = $especialista->user->email;
        $validated['attendees'] = [$emailPaciente, $emailClinica, $emailEspecialista];
       // dd($validated);
        // dd($validated);
        try {
            $event = $this->buildEvent($validated);
            $createdEvent = $this->service->events->insert($this->calendarId, $event, ['conferenceDataVersion' => 1]);
      //      dd($createdEvent);
            if ($validated["remota"]) {
                $meetLink = $createdEvent->getConferenceData()->getEntryPoints()[0]->getUri();
            }
            $consulta->convite = $createdEvent->getHtmlLink();
            if ($validated["remota"]){
                $consulta->linkmeet = $createdEvent->getConferenceData()->getEntryPoints()[0]->getUri();
            }
            $consulta->calendarId = $createdEvent["id"];
            $consulta->save();
//            dd($createdEvent["id"]);

            // dd($validated["remota"]);

            return response()->json([
                'success' => true,
                'event' => $this->formatEventResponseMeet($createdEvent)
            ]);

        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Lista eventos do calendário
     */
    public function listEvents(Request $request)
    {
        try {
            $optParams = [
                'maxResults' => $request->get('limit', 10),
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => now()->toRfc3339String(),
            ];

            if ($request->has('q')) {
                $optParams['q'] = $request->get('q');
            }

            $events = $this->service->events->listEvents($this->calendarId, $optParams);

            return response()->json([
                'success' => true,
                'events' => array_map([$this, 'formatEventResponse'], $events->getItems())
            ]);

        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Atualiza um evento existente
     */
    public function updateEvent(Request $request, $eventId)
    {
        $validated = $this->validateEventRequest($request);

        try {
            $event = $this->buildEvent($validated);
            $updatedEvent = $this->service->events->update($this->calendarId, $eventId, $event);

            return response()->json([
                'success' => true,
                'event' => $this->formatEventResponse($updatedEvent)
            ]);

        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Remove um evento
     */
    public function deleteEvent($eventId)
    {
        try {
            $this->service->events->delete($this->calendarId, $eventId);

            return response()->json([
                'success' => true,
                'message' => 'Evento removido com sucesso'
            ]);

        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Valida os dados do evento
     */
    private function validateEventRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'attendees' => 'nullable|array',
            'attendees.*' => 'email',
        ]);
    }

    /**
     * Constrói o objeto Event do Google Calendar
     */
    private function buildEvent(array $data)
    {
        $event = new Event([
            'summary' => $data['title'],
            'location' => $data['location'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        $event->setStart(new EventDateTime([
            'dateTime' => $data['start_time'],
            'timeZone' => config('app.timezone'),
        ]));

        $event->setEnd(new EventDateTime([
            'dateTime' => $data['end_time'],
            'timeZone' => config('app.timezone'),
        ]));

        if (!empty($data['attendees'])) {
            $attendees = array_map(function ($email) {
                return ['email' => $email];
            }, $data['attendees']);

            $event->setAttendees($attendees);
        }
       if  ($data["remota"]) {

           $event->setConferenceData(new \Google_Service_Calendar_ConferenceData([
               'createRequest' => new \Google_Service_Calendar_CreateConferenceRequest([
                   'requestId' => uniqid(), // ID único para cada solicitação
                   'conferenceSolutionKey' => new \Google_Service_Calendar_ConferenceSolutionKey([
                       'type' => 'hangoutsMeet' // Tipo de conferência (Google Meet)
                   ])
               ])
           ]));
       }

        return $event;
    }

    /**
     * Formata a resposta do evento
     */
    private function formatEventResponse(Event $event)
    {
        return [
            'id' => $event->getId(),
            'title' => $event->getSummary(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
            'start' => $event->getStart()->getDateTime(),
            'end' => $event->getEnd()->getDateTime(),
            'htmlLink' => $event->getHtmlLink(),
            'attendees' => array_map(function ($attendee) {
                return $attendee->getEmail();
            }, $event->getAttendees() ?: []),
            // 'meet_link' => $event->getConferenceData()->getEntryPoints()[0]->getUri(),
        ];
    }
    private function formatEventResponseMeet(Event $event, $remota=false)
    {
        return [
            'id' => $event->getId(),
            'title' => $event->getSummary(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
            'start' => $event->getStart()->getDateTime(),
            'end' => $event->getEnd()->getDateTime(),
            'htmlLink' => $event->getHtmlLink(),
            'attendees' => array_map(function ($attendee) {
                return $attendee->getEmail();
            }, $event->getAttendees() ?: []),
            'meet_link' => $remota? $event->getConferenceData()->getEntryPoints()[0]->getUri():"",
        ];
    }

    /**
     * Trata erros da API
     */
    private function handleError(\Exception $e)
    {
        $statusCode = method_exists($e, 'getCode') ? $e->getCode() : 500;
        return response()->json([
            'success' => false,
            'message' => 'Erro no Google Calendar: ' . $e->getMessage()
        ], $statusCode >= 400 && $statusCode < 600 ? $statusCode : 500);
    }
}
