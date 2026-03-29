<?php

namespace App\Enums;

enum DocumentType: int
{
    case DeclarationOfConformity = 1;
    case TechnicalFile = 2;
    case RiskAssessment = 3;
    case TestReport = 4;
    case UserManual = 5;
    case Certificate = 6;
    case Other = 7;
}
