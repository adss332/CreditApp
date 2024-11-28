<?php

declare(strict_types=1);

namespace App\Client\Domain\Enum;

enum ClientStatesEnum: string
{
    case AL = 'AL';

    case AK = 'AK';

    case AZ = 'AZ';

    case AR = 'AR';

    case CA = 'CA';

    case CO = 'CO';

    case CT = 'CT';

    case DE = 'DE';

    case FL = 'FL';

    case GA = 'GA';

    case HI = 'HI';

    case ID = 'ID';

    case IL = 'IL';

    case IN = 'IN';

    case IA = 'IA';

    case KS = 'KS';

    case KY = 'KY';

    case LA = 'LA';

    case ME = 'ME';

    case MD = 'MD';

    case MA = 'MA';

    case MI = 'MI';

    case MN = 'MN';

    case MS = 'MS';

    case MO = 'MO';

    case MT = 'MT';

    case NE = 'NE';

    case NV = 'NV';

    case NH = 'NH';

    case NJ = 'NJ';

    case NM = 'NM';

    case NY = 'NY';

    case NC = 'NC';

    case ND = 'ND';

    case OH = 'OH';

    case OK = 'OK';

    case OR = 'OR';

    case PA = 'PA';

    case RI = 'RI';

    case SC = 'SC';

    case SD = 'SD';

    case TN = 'TN';

    case TX = 'TX';

    case UT = 'UT';

    case VT = 'VT';

    case VA = 'VA';

    case WA = 'WA';

    case WV = 'WV';

    case WI = 'WI';

    case WY = 'WY';

    /** @return string[] */
    public static function values(): array
    {
        return array_map(
            static fn (self $case): string => $case->value,
            self::cases(),
        );
    }

    public static function stateForRandomRefusal(): string
    {
        return self::CA->value;
    }

    /** @return string[] */
    public static function allowedToGetCreditForClient(): array
    {
        return [
            self::CA->value,
            self::NY->value,
            self::NV->value,
        ];
    }

    public static function stateWithBigRate(): string
    {
        return self::CA->value;
    }
}
