<?php

/**
 * Class LocationController
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Controller\API
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 19/12/2024
 */

namespace App\Controller\API;
use App\Repository\CityRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/regions', name: 'api_get_regions', options: ['expose' => true], methods: ['GET'])]
    public function getRegions(Request $request, RegionRepository $regionRepository): JsonResponse
    {
        $countryId = $request->query->get('country');

        if (!$countryId) {
            return new JsonResponse(['error' => 'Country ID missing'], 400);
        }

        $regions = $regionRepository->findBy(['country' => $countryId]);

        $data = [];
        foreach ($regions as $region) {
            $data[] = [
                'id' => $region->getId(),
                'name' => $region->getName(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/cities', name: 'api_get_cities', options: ['expose' => true], methods: ['GET'])]
    public function getCities(Request $request, CityRepository $cityRepository): JsonResponse
    {
        $regionId = $request->query->get('region');

        if (!$regionId) {
            return new JsonResponse(['error' => 'Region ID missing'], 400);
        }

        $cities = $cityRepository->findBy(['region' => $regionId]);

        $data = [];
        foreach ($cities as $city) {
            $data[] = [
                'id' => $city->getId(),
                'name' => $city->getName(),
            ];
        }

        return new JsonResponse($data);
    }
}