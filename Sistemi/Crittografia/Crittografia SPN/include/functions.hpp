#pragma once 

#include <array>
#include "constants.hpp"

std::array<int, 4> to_binary(const int& number);
int to_decimal(std::array<int, 4>& gruppo);
std::array<int, 4> sbox(std::array<int, 4>& gruppo);
std::array<int, 8> convert_to_sbox(std::array<int, 8>& blocco);