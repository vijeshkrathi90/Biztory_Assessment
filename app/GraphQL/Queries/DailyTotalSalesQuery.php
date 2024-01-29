<?php

namespace App\GraphQL\Queries;

use App\Models\Sale;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Closure;

class DailyTotalSalesQuery
{
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // Your logic to calculate total sales based on the provided parameters
        $startDate = $args['startDate'];
        $endDate = $args['endDate'];
        $paymentStatus = $args['paymentStatus'] ?? null;
        $payeeId = $args['payeeId'] ?? null;

        // Your logic to filter and calculate total sales
        // Example: Use Eloquent queries
        $totalSales = Sale::whereBetween('invoice_date', ["$startDate", "$endDate"])
            ->when($paymentStatus !== null, function ($query) use ($paymentStatus) {
                return $query->where('payment_status', $paymentStatus);
            })
            ->when($payeeId !== null, function ($query) use ($payeeId) {
                return $query->where('payee_id', $payeeId);
            })
            ->sum('total');

        return $totalSales;
    }
}
