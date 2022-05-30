<?php
namespace app\usecases;

use app\models\IFieldsRepository;

class GetFieldsUseCase {
    private $repository;

    function __construct(IFieldsRepository $repository) {
        $this->repository = $repository;
    }

    function __invoke() {
        return $this->repository->get();
    }
}