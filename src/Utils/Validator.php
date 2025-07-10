<?php

namespace SmartSecurity\Utils;

class Validator
{
    private array $errors = [];
    private array $data = [];
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function required(string $field, string $message = null): self
    {
        if (!isset($this->data[$field]) || empty(trim($this->data[$field]))) {
            $this->errors[$field][] = $message ?? "O campo {$field} é obrigatório.";
        }
        return $this;
    }
    
    public function email(string $field, string $message = null): self
    {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message ?? "O campo {$field} deve ser um email válido.";
        }
        return $this;
    }
    
    public function min(string $field, int $min, string $message = null): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $min) {
            $this->errors[$field][] = $message ?? "O campo {$field} deve ter pelo menos {$min} caracteres.";
        }
        return $this;
    }
    
    public function max(string $field, int $max, string $message = null): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $max) {
            $this->errors[$field][] = $message ?? "O campo {$field} deve ter no máximo {$max} caracteres.";
        }
        return $this;
    }
    
    public function cpf(string $field, string $message = null): self
    {
        if (isset($this->data[$field]) && !$this->isValidCpf($this->data[$field])) {
            $this->errors[$field][] = $message ?? "O campo {$field} deve ser um CPF válido.";
        }
        return $this;
    }
    
    public function date(string $field, string $message = null): self
    {
        if (isset($this->data[$field]) && !strtotime($this->data[$field])) {
            $this->errors[$field][] = $message ?? "O campo {$field} deve ser uma data válida.";
        }
        return $this;
    }
    
    public function numeric(string $field, string $message = null): self
    {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field][] = $message ?? "O campo {$field} deve ser numérico.";
        }
        return $this;
    }
    
    public function in(string $field, array $values, string $message = null): self
    {
        if (isset($this->data[$field]) && !in_array($this->data[$field], $values)) {
            $this->errors[$field][] = $message ?? "O campo {$field} deve ser um dos valores: " . implode(', ', $values);
        }
        return $this;
    }
    
    public function isValid(): bool
    {
        return empty($this->errors);
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function getFirstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
    
    private function isValidCpf(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        
        return true;
    }
}

