<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Players;
use App\Models\Proposals;

class PlayerController extends Controller
{
    public function registerPlayer(Request $request) {
        $validation = $request->validate([
          'name' => 'required|string',
          'position' => 'required|string',
        ]);
        $user = Users::where('remember_token', $request->bearerToken())->first();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } else {
            if ($user->isAdmin != 0) {
                $newPlayer = Players::create([
                  'name' => $request->name,
                  'position' => $request->position,
                  'created_by' => $user->id,
                  'modified_by' => $user->id
                ]);
            } else {
                $newPlayer = Proposals::create([
                  'create_by' => $user->id,
                  'name' => $request->name,
                  'position' => $request->position,
                  'description' => $request->description
                ]);
            }
            if (!$newPlayer) {
                return response()->json([
                  'status' => 'error',
                  'message' => 'Error at creating player'
                ], 500);
            } else {
                return response()->json([
                  'status' => 'success',
                  'message' => 'Create new player successful',
                  'player' => $newPlayer
                ])
            }
        }
    }
    public function getPlayers(Request $request) {
      $token = bearerToken();
      if (!$token) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid token'
        ], 401);
      } else {
        $players = Players::all();
        if (!$players) {
          return response()->json([
              'status' => 'error',
              'message' => 'Error at getting players'
          ], 500);
        }
        return response()->json([
          'status' => 'success',
          'players' => $players
        ], 200);
      }
    }
    public function getPlayerById(Request $request, $id) {
      $token = bearerToken();
      if (!$token) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid token'
        ], 401);
      } else {
        $player = Players::where('id', $id)->first();
        if (!$player) {
          return response()->json([
              'status' => 'error',
              'message' => 'Error at getting player'
          ], 500);
        }
        return response()->json([
          'status' => 'success',
          'player' => $player
        ], 200);
      }
    }
    public function modifyPlayerById(Request $request, $id) {
      $token = bearerToken();
      if (!$token) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid token'
        ], 401);    
      }
      $user = Users::where('remember_token', $token)->first();
      if (!$user) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid token'
        ], 401);
      } else {
        $update = Players::where('id', $request->id)->update([
          'name' => $request->name,
          'position' => $request->position,
          'modified_by' => $user->id
        ]);
        if (!$update) {
          return response()->json([
            'status' => 'error',
            'message' => 'Error at updating player'
          ], 500);
        }
        return response()->json([
          'status' => 'success',
          'message' => 'Update successful'
        ], 200);
      }
    }
    public function deletePlayerById(Request $request, $id {
      $token = bearerToken();
      if (!$token) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid token'
        ]);
      }
      $user = Users::where('remember_token', $token)->first();
      if (!$user) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid token'
        ], 401);
      } else {
        $delete = Players::where('id', $request->id)->delete();
        if (!$delete) {
          return response()->json([
            'status' => 'error',
            'message' => 'Error at deleting player'
          ], 500);
        }
        return response()->json([
          'status' => 'success',
          'message' => 'Delete successful'
        ], 200);
      }
    }
}
