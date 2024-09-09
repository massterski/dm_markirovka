<?php
namespace Massterski\DmMarkirovka\Dto;

class IsmetDTO
{
  public string $tail;
  public array $binArr;
  public array $codes;
  public string $direction;
  public ?string $fromDate;
  public int $pageNum;
  public int $rowCount;
  public int $documentId;
  public int $edoid;
  public string $bin;
  public int $limit;
  public ?string $sortBy;
  public ?string $state;
  public ?string $toDate;
  public ?string $typeDoc;
  public function bodyDocumentList($data): array
  {
    $this->tail = $data['tail'];
    $this->binArr = $data['binArr'];
    $this->pageNum = $data['page'];
    $this->rowCount = $data['count'];

    return [
      'tail' => $this->tail,
      'body' => [
        'bin' => $this->binArr ?? null,
        'direction' => $this->direction ?? "DESC",
        'fromDate' => $this->fromDate  ?? null,
        'pageNum' => $this->pageNum,
        'rowCount' => $this->rowCount,
        'sortBy' => $this->sortBy ?? null,
        'state' => $this->state ?? null,
        'toDate' => $this->toDate ?? null,
        'typeDoc' => $this->typeDoc ?? null,
      ]
    ];
  }
  public function bodyCheckDataMatrix($data): array
  {
    $this->codes = $data['codes'];
    $this->documentId = $data['documentId'];
    return [
      "codes" => $this->codes,
      "documentId" => $this->documentId
    ];
  }
  public function bodyDocumentProfile($data): array
  {
    $this->bin = $data['bin'];
    $this->documentId = $data['documentId'];
    return [
      "bin" => $this->bin,
      "documentId" => $this->documentId,
      "edoId" => null
    ];
  }

  public function bodyDocumentDataMatrixCodes($limit): array
  {
    $this->limit = $limit;
    return [
      "limit" => $this->limit,
      "type" => 1,
      "page" => 1
    ];
  }

  public function bodyDocumentId($data): array
  {
    $this->bin = $data['bin'];
    $this->codes = $data['codes'];
    return [
      "bin" => $this->bin,
      "codes" => $this->codes
    ];
  }
}
