<?php

namespace CVGenerator;

class CVData
{
    private array $data = [];

    public function setPersonalInfo(
        string $firstName,
        string $lastName,
        string $address,
        string $telephone,
        string $email,
        ?string $linkedin = null
    ): self {
        $this->data['first_name'] = $firstName;
        $this->data['last_name'] = $lastName;
        $this->data['address'] = $address;
        $this->data['telephone'] = $telephone;
        $this->data['email'] = $email;
        if ($linkedin) {
            $this->data['linkedin'] = $linkedin;
        }
        return $this;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->data['introduction'] = $introduction;
        return $this;
    }

    public function addExperience(
        string $company,
        string $role,
        string $dateStart,
        string $dateEnd,
        array $bullets,
        ?string $reference = null
    ): self {
        if (!isset($this->data['experience'])) {
            $this->data['experience'] = [];
        }
        
        $experience = [
            'company' => $company,
            'role' => $role,
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'bullets' => $bullets
        ];
        
        if ($reference) {
            $experience['reference'] = $reference;
        }
        
        $this->data['experience'][] = $experience;
        return $this;
    }

    public function addEducation(
        string $institution,
        string $qualification,
        string $dateStart,
        string $dateEnd,
        array $bullets
    ): self {
        if (!isset($this->data['education'])) {
            $this->data['education'] = [];
        }
        
        $this->data['education'][] = [
            'institution' => $institution,
            'qualification' => $qualification,
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'bullets' => $bullets
        ];
        return $this;
    }

    public function addOptionalSection(
        string $title,
        array $bullets,
        ?string $subtitle = null
    ): self {
        if (!isset($this->data['optional'])) {
            $this->data['optional'] = [];
        }
        
        $section = [
            'title' => $title,
            'bullets' => $bullets
        ];
        
        if ($subtitle) {
            $section['subtitle'] = $subtitle;
        }
        
        $this->data['optional'][] = $section;
        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }
} 