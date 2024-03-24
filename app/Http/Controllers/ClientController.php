<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClassificationService;
use App\Services\ClientService;
use App\Services\OperatorService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        protected ClientService $clientService,
        protected OperatorService $operatorService,
        protected ClassificationService $classificationService,
        protected UserService $userService
    )
    {
    }

    public function index()
    {
        return view('app.clients.index');
    }

    public function create()
    {
        $view = [
            'classifications' => $this->classificationService->toSelect(),
            'operators' => $this->operatorService->toSelect(),
            'users' => $this->userService->toSelect()
        ];
        return view('app.clients.create', $view);
    }

    public function store(Request $request)
    {
        $client = $this->clientService->store($request->all());
        if ($client) {
            flash()->addSuccess('Cliente cadastrado com sucesso.');
            return redirect()->route('clients.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Cliente.');
            return back();
        }
    }

    public function edit($id)
    {
        $client = $this->clientService->get($id);
        if(!$client){
            flash()->addError('Ops! Cliente não encontrado.');
            return back();
        }
        $view = [
            'data' => $client,
            'classifications' => $this->classificationService->toSelect(),
            'operators' => $this->operatorService->toSelect(),
            'users' => $this->userService->toSelect()
        ];

        return view('app.clients.edit', $view);
    }

    public function update(Request $request, $id)
    {
        $client = $this->clientService->update($request->all(), $id);
        if ($client) {
            flash()->addSuccess('Cliente atualizado com sucesso.');
            return redirect()->route('clients.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Cliente.');
            return back();
        }
    }

    public function destroy($id)
    {
        $client = $this->clientService->get($id, true);
        $this->clientService->destroy($id);
        if ($client->deleted_at === null) {
            flash()->addSuccess('Cliente desativado com sucesso.');
            return redirect()->route('clients.index');
        } elseif ($client->deleted_at != null) {
            flash()->addSuccess('Cliente reativado com sucesso.');
            return redirect()->route('clients.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Cliente.');
            return back();
        }
    }

    public function autocomplete(Request $request)
    {
        $params = $request->input('query');
        $filterResult = Client::with('user')->where('tenant_id', auth()->user()->tenant->id)->where(function ($query) use ($params) {
            $query->where('document', 'LIKE', '%' . $params . '%')
                ->orWhere('name', 'LIKE', '%' . $params . '%');
        })->get();

        return response()->json($filterResult);
    }

    public function myProtocols($uuid)
    {
        $client = Client::where('uuid', $uuid)->first();

        $view = [
            'client' => $client,
//            'protocols' => Protocol::orderBy('created_at', 'desc')->where('client_id', $client->id)->paginate()
        ];

        return view('clients.my-protocols', $view);
    }

    public function getClientDocument($doc)
    {
        return Client::where('tenant_id', auth()->user()->tenant->id)->where('document', $doc)->first();
    }

    public function getClient($id)
    {
        $client = Client::with('user')->where('tenant_id', auth()->user()->tenant->id)->where('id', $id)->first();
        if (!$client) {
            flash()->addError('Registro não encontrado.');
            return back();
        }

        return response()->json($client);
    }
}
