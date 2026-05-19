<?php

declare(strict_types=1);

namespace Service;

use Core\Env;
use MongoDB\Client;
use MongoDB\Collection;

class MongoService
{
    private Collection $collection;

    public function __construct()
    {
        $host     = Env::get('MONGO_HOST',          'mongo');
        $port     = Env::get('MONGO_PORT',          '27017');
        $user     = Env::get('MONGO_ROOT_USER',     'root');
        $password = Env::get('MONGO_ROOT_PASSWORD', 'rootpassword');
        $database = Env::get('MONGO_DATABASE',      'ju_coach_stats');

        $uri = "mongodb://{$user}:{$password}@{$host}:{$port}";

        $client           = new Client($uri);
        $this->collection = $client->$database->commandes_stats;
    }

    /* Enregistre une commande dans MongoDB après paiement confirmé */

    public function enregistrerCommande(
        int    $commandeId,
        int    $programmeId,
        string $programmeTitre,
        string $programmeType,
        string $dateAchat,
        float  $montant
    ): void {
        try {
            $this->collection->insertOne([
                'commande_id'     => $commandeId,
                'programme_id'    => $programmeId,
                'programme_titre' => $programmeTitre,
                'programme_type'  => $programmeType,
                'date_achat'      => $dateAchat,
                'montant'         => $montant,
                'statut'          => 'choisi',
                'created_at'      => new \MongoDB\BSON\UTCDateTime(time() * 1000),
            ]);

        } catch (\Exception $e) {
            error_log('[MongoService::enregistrerCommande] ' . $e->getMessage());
        }
    }

    /* Nombre de commandes par programme */

    public function getNombreCommandesParProgramme(): array
    {
        try {
            $pipeline = [
                [
                    '$group' => [
                        '_id'              => [
                            'programme_id'    => '$programme_id',
                            'programme_titre' => '$programme_titre',
                            'programme_type'  => '$programme_type',
                        ],
                        'nombre_commandes' => ['$sum' => 1],
                    ]
                ],
                ['$sort' => ['nombre_commandes' => -1]],
            ];

            $result = $this->collection->aggregate($pipeline)->toArray();

            return array_map(function ($item) {
                return [
                    'programme_id'    => $item['_id']['programme_id'],
                    'programme_titre' => $item['_id']['programme_titre'],
                    'programme_type'  => $item['_id']['programme_type'],
                    'nombre_commandes' => $item['nombre_commandes'],
                ];
            }, $result);

        } catch (\Exception $e) {
            error_log('[MongoService::getNombreCommandesParProgramme] ' . $e->getMessage());
            return [];
        }
    }

    /* CA par programme sur une période */

    public function getCAParProgramme(string $dateDebut, string $dateFin): array
    {
        try {
            $pipeline = [
                [
                    '$match' => [
                        'date_achat' => [
                            '$gte' => $dateDebut,
                            '$lte' => $dateFin,
                        ]
                    ]
                ],
                [
                    '$group' => [
                        '_id'              => [
                            'programme_id'    => '$programme_id',
                            'programme_titre' => '$programme_titre',
                            'programme_type'  => '$programme_type',
                        ],
                        'chiffre_affaires' => ['$sum' => '$montant'],
                        'nombre_commandes' => ['$sum' => 1],
                    ]
                ],
                ['$sort' => ['chiffre_affaires' => -1]],
            ];

            $result = $this->collection->aggregate($pipeline)->toArray();

            return array_map(function ($item) {
                return [
                    'programme_id'    => $item['_id']['programme_id'],
                    'programme_titre' => $item['_id']['programme_titre'],
                    'programme_type'  => $item['_id']['programme_type'],
                    'chiffre_affaires' => round((float) $item['chiffre_affaires'], 2),
                    'nombre_commandes' => $item['nombre_commandes'],
                ];
            }, $result);

        } catch (\Exception $e) {
            error_log('[MongoService::getCAParProgramme] ' . $e->getMessage());
            return [];
        }
    }

    /* CA total sur une période */

    public function getCATotalPeriode(string $dateDebut, string $dateFin): float
    {
        try {
            $pipeline = [
                [
                    '$match' => [
                        'date_achat' => ['$gte' => $dateDebut, '$lte' => $dateFin]
                    ]
                ],
                [
                    '$group' => [
                        '_id'   => null,
                        'total' => ['$sum' => '$montant'],
                    ]
                ],
            ];

            $result = $this->collection->aggregate($pipeline)->toArray();

            return isset($result[0]) ? round((float) $result[0]['total'], 2) : 0.0;

        } catch (\Exception $e) {
            error_log('[MongoService::getCATotalPeriode] ' . $e->getMessage());
            return 0.0;
        }
    }
}
