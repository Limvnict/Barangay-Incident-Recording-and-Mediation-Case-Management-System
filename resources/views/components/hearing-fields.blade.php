@props(['hearing' => null])
<x-input-field label="Stage" name="stage" type="select" :options="\App\Models\Hearing::STAGES" :value="$hearing?->stage ?? ''" />
<x-input-field label="Hearing date and time" name="hearing_date" type="datetime-local" :value="$hearing?->hearing_date->format('Y-m-d\TH:i') ?? ''" />
<x-input-field label="Outcome" name="outcome" type="select" :options="\App\Models\Hearing::OUTCOMES" :value="$hearing?->outcome ?? ''" />
<x-input-field label="Summons delivery status" name="service_status" type="select" :options="\App\Models\Hearing::SERVICE" :value="$hearing?->service_status ?? ''" />
<x-input-field label="Served by (name of tanod / secretary)" name="served_by" :value="$hearing?->served_by ?? ''" />
<x-input-field label="Date served" name="served_date" type="date" :value="$hearing?->served_date?->format('Y-m-d') ?? ''" />
<x-input-field label="Notes / agreement" name="notes" type="textarea" :value="$hearing?->notes ?? ''" />
