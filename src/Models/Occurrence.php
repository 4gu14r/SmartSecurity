<?php

namespace SmartSecurity\Models;

class Occurrence extends BaseModel
{
    protected string $table = 'ocorrencia';
    protected string $primaryKey = 'cod';
    protected array $fillable = [
        'tipo',
        'localizacao',
        'referencia',
        'dt_registro',
        'hr_registro',
        'titulo_registro',
        'marca',
        'modelo',
        'cor',
        'imei',
        'descricao',
        'usuario_id'
    ];
    
    public function getOccurrencesByUser(int $userId): array
    {
        return $this->where('usuario_id', $userId);
    }
    
    public function getOccurrencesWithUser(): array
    {
        $sql = "
            SELECT o.*, u.nome, u.sobrenome, u.email
            FROM ocorrencia o
            LEFT JOIN usuario u ON o.usuario_id = u.id
            ORDER BY o.dt_registro DESC
        ";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getOccurrencesByLocation(string $location): array
    {
        $sql = "
            SELECT o.*, u.nome, u.sobrenome
            FROM ocorrencia o
            LEFT JOIN usuario u ON o.usuario_id = u.id
            WHERE o.localizacao LIKE ?
            ORDER BY o.dt_registro DESC
        ";
        
        $stmt = $this->query($sql, ["%{$location}%"]);
        return $stmt->fetchAll();
    }
    
    public function getOccurrencesByType(string $type): array
    {
        $sql = "
            SELECT o.*, u.nome, u.sobrenome
            FROM ocorrencia o
            LEFT JOIN usuario u ON o.usuario_id = u.id
            WHERE o.tipo = ?
            ORDER BY o.dt_registro DESC
        ";
        
        $stmt = $this->query($sql, [$type]);
        return $stmt->fetchAll();
    }
    
    public function searchOccurrences(string $search): array
    {
        $sql = "
            SELECT o.*, u.nome, u.sobrenome
            FROM ocorrencia o
            LEFT JOIN usuario u ON o.usuario_id = u.id
            WHERE o.localizacao LIKE ? 
               OR o.referencia LIKE ? 
               OR o.titulo_registro LIKE ?
               OR o.descricao LIKE ?
            ORDER BY o.dt_registro DESC
        ";
        
        $searchTerm = "%{$search}%";
        $stmt = $this->query($sql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function getOccurrenceStats(): array
    {
        $sql = "
            SELECT 
                COUNT(*) as total_occurrences,
                COUNT(CASE WHEN tipo = 'Assalto' THEN 1 END) as assaults,
                COUNT(CASE WHEN tipo = 'Perda' THEN 1 END) as losses,
                COUNT(CASE WHEN DATE(dt_registro) = CURDATE() THEN 1 END) as today,
                COUNT(CASE WHEN DATE(dt_registro) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) as this_week,
                COUNT(CASE WHEN DATE(dt_registro) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as this_month
            FROM ocorrencia
        ";
        
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }
    
    public function getLocationStats(): array
    {
        $sql = "
            SELECT 
                localizacao,
                COUNT(*) as total,
                COUNT(CASE WHEN tipo = 'Assalto' THEN 1 END) as assaults,
                COUNT(CASE WHEN tipo = 'Perda' THEN 1 END) as losses
            FROM ocorrencia 
            WHERE localizacao IS NOT NULL AND localizacao != ''
            GROUP BY localizacao 
            ORDER BY total DESC 
            LIMIT 10
        ";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getMonthlyStats(): array
    {
        $sql = "
            SELECT 
                DATE_FORMAT(dt_registro, '%Y-%m') as month,
                COUNT(*) as total,
                COUNT(CASE WHEN tipo = 'Assalto' THEN 1 END) as assaults,
                COUNT(CASE WHEN tipo = 'Perda' THEN 1 END) as losses
            FROM ocorrencia 
            WHERE dt_registro >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(dt_registro, '%Y-%m')
            ORDER BY month DESC
        ";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getRecentOccurrences(int $limit = 5): array
    {
        $sql = "
            SELECT o.*, u.nome, u.sobrenome
            FROM ocorrencia o
            LEFT JOIN usuario u ON o.usuario_id = u.id
            ORDER BY o.dt_registro DESC
            LIMIT ?
        ";
        
        $stmt = $this->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
}

